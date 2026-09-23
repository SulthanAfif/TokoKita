<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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

    public function payment(Order $order, MidtransService $midtrans)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan ini sudah tidak menunggu pembayaran.');
        }

        if (!in_array($order->payment_method, ['transfer_bank', 'e_wallet', 'midtrans'])) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Halaman pembayaran hanya untuk metode online.');
        }

        if (!$midtrans->isConfigured()) {
            Log::error('Midtrans belum dikonfigurasi (SERVER_KEY / CLIENT_KEY kosong)');
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pembayaran online belum dikonfigurasi. Hubungi admin.');
        }

        $order->load('items');

        // SELALU buat token baru (order_id unik) — jangan reuse token lama
        // Token lama sering invalid / order_id sudah dipakai di Midtrans
        $snap = $midtrans->createSnapToken($order);
        $snapToken = $snap['token'] ?? null;

        if (!$snapToken) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Gagal membuat token pembayaran. Coba lagi beberapa saat, atau buat pesanan baru.');
        }

        return view('orders.payment', [
            'order'     => $order,
            'snapToken' => $snapToken,
            'clientKey' => $midtrans->getClientKey(),
            'snapJsUrl' => $midtrans->getSnapJsUrl(),
        ]);
    }

    public function processPayment(Request $request, Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        return redirect()->route('orders.show', $order)
            ->with('success', 'Terima kasih! Status akan update otomatis setelah Midtrans mengonfirmasi pembayaran.');
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
                    Product::where('id', $item->product_id)->increment('stock', $item->quantity);
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
            return back()->with('error', 'Metode pembayaran tidak dapat diubah.');
        }

        $request->validate([
            'payment_method' => 'required|in:transfer_bank,e_wallet,cod,midtrans',
        ]);

        $data = ['payment_method' => $request->payment_method];
        if (Schema::hasColumn('orders', 'snap_token')) {
            $data['snap_token'] = null;
        }
        $order->update($data);

        return back()->with('success', 'Metode pembayaran berhasil diubah.');
    }
}
