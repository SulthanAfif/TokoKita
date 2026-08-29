<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
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
     * Halaman pembayaran (transfer / e-wallet).
     */
    public function payment(Order $order)
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
        return view('orders.payment', compact('order'));
    }

    /**
     * Proses pembayaran + verifikasi otomatis.
     * Status langsung berubah jadi "paid" tanpa perlu admin konfirmasi.
     */
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

        // Verifikasi otomatis: anggap pembayaran berhasil
        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pembayaran berhasil diverifikasi secara otomatis! Pesanan Anda sudah masuk ke admin untuk diproses.');
    }

    /**
     * Batalkan pesanan (hanya jika masih pending).
     */
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

    /**
     * Ubah metode pembayaran (hanya jika masih pending).
     */
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
}
