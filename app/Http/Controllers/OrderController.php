<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Auth::user()->orders()
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        $order->load('items', 'address');
        return view('orders.show', compact('order'));
    }

    /**
     * Halaman pembayaran (khusus transfer bank & e-wallet)
     * Menampilkan tombol yang membuka popup Midtrans Snap.
     */
    public function payment(Order $order, MidtransService $midtrans)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan ini sudah tidak menunggu pembayaran.');
        }

        if (!in_array($order->payment_method, ['transfer_bank', 'e_wallet'])) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Halaman pembayaran hanya untuk Transfer Bank atau E-Wallet.');
        }

        $order->load('items');

        try {
            $snap = $midtrans->createSnapTransaction($order);
        } catch (\Throwable $e) {
            Log::error('Gagal membuat Snap token: ' . $e->getMessage());
            return redirect()->route('orders.show', $order)
                ->with('error', 'Gagal menghubungi Midtrans, silakan coba lagi.');
        }

        return view('orders.payment', [
            'order'      => $order,
            'snapToken'  => $snap['token'],
            'clientKey'  => config('services.midtrans.client_key'),
            'isProduction' => (bool) config('services.midtrans.is_production'),
        ]);
    }

    // processPayment() dibiarkan seperti semula (sudah tidak dipakai dari view lagi)
    public function processPayment(Request $request, Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan ini sudah tidak menunggu pembayaran.');
        }

        if (!in_array($order->payment_method, ['transfer_bank', 'e_wallet'])) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pembayaran online hanya untuk Transfer Bank atau E-Wallet.');
        }

        $order->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pembayaran berhasil diverifikasi secara otomatis! Pesanan Anda sudah masuk ke admin untuk diproses.');
    }

    public function cancel(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)
                        ->increment('stock', $item->quantity);
                }
            }
            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function updatePaymentMethod(Request $request, Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Metode pembayaran tidak dapat diubah karena pesanan sudah diproses.');
        }

        $request->validate([
            'payment_method' => 'required|in:transfer_bank,e_wallet,cod',
        ]);

        $order->update(['payment_method' => $request->payment_method]);

        return back()->with('success', 'Metode pembayaran berhasil diubah.');
    }

    /**
     * Webhook notifikasi dari Midtrans.
     * Route ini PUBLIK (tanpa auth, tanpa CSRF) karena dipanggil oleh server
     * Midtrans, bukan oleh browser user.
     */
    public function handleNotification(Request $request, MidtransService $midtrans)
    {
        $payload = $request->all();

        Log::info('Midtrans notification diterima', $payload);

        if (!$midtrans->isValidSignature($payload)) {
            Log::warning('Midtrans notification: signature tidak valid', $payload);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $midtransOrderId = $payload['order_id'] ?? '';
        $order = Order::where('midtrans_order_id', $midtransOrderId)->first();

        if (!$order) {
            Log::warning('Midtrans notification: order tidak ditemukan', ['order_id' => $midtransOrderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus        = $payload['fraud_status'] ?? null;

        if (in_array($order->status, ['cancelled'])) {
            return response()->json(['message' => 'Order already final']);
        }

        $newStatus = match (true) {
            in_array($transactionStatus, ['capture', 'settlement']) && $fraudStatus !== 'challenge' => 'paid',
            in_array($transactionStatus, ['deny', 'cancel', 'expire']) => 'cancelled',
            default => $order->status,
        };

        $previousStatus = $order->status;

        $order->update([
            'status'                   => $newStatus,
            'paid_at'                  => $newStatus === 'paid' ? now() : $order->paid_at,
            'midtrans_transaction_id'  => $payload['transaction_id'] ?? $order->midtrans_transaction_id,
            'payment_type'             => $payload['payment_type'] ?? $order->payment_type,
        ]);

        if ($newStatus === 'cancelled' && $previousStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                }
            }
        }

        return response()->json(['message' => 'OK']);
    }
}