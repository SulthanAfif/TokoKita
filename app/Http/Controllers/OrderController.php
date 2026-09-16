<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * OrderController (Customer)
 * --------------------------
 * Mengatur halaman pesanan dari sisi customer:
 * - Daftar pesanan
 * - Detail pesanan
 * - Halaman & proses pembayaran
 * - Batalkan pesanan
 * - Ubah metode pembayaran
 */
class OrderController extends Controller
{
    /**
     * Daftar semua pesanan milik user yang login
     * Bisa difilter berdasarkan status (?status=pending)
     */
    public function index(Request $request)
    {
        $orders = Auth::user()->orders()
            // Filter status jika ada parameter ?status=
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()                          // Urutkan terbaru dulu
            ->paginate(10)                      // 10 per halaman
            ->withQueryString();                // Tetap bawa parameter filter di pagination

        return view('orders.index', compact('orders'));
    }

    /**
     * Detail 1 pesanan
     * Hanya pemilik pesanan yang boleh melihat
     */
    public function show(Order $order)
    {
        // Keamanan: pastikan order milik user yang sedang login
        abort_if($order->user_id !== Auth::id(), 403);

        // Load item + alamat
        $order->load('items', 'address');

        return view('orders.show', compact('order'));
    }

    /**
     * Halaman pembayaran (khusus transfer bank & e-wallet)
     */
    public function payment(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        // Hanya pesanan pending yang boleh dibayar
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan ini sudah tidak menunggu pembayaran.');
        }

        // Hanya metode online yang punya halaman bayar
        if (!in_array($order->payment_method, ['transfer_bank', 'e_wallet'])) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Halaman pembayaran hanya untuk Transfer Bank atau E-Wallet.');
        }

        $order->load('items');
        return view('orders.payment', compact('order'));
    }

    /**
     * Proses pembayaran (simulasi)
     * Status langsung diubah jadi "paid" tanpa perlu admin konfirmasi.
     * (Di production biasanya diganti integrasi Midtrans / Xendit / dll)
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

        // Update status menjadi paid + catat waktu bayar
        $order->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pembayaran berhasil diverifikasi secara otomatis! Pesanan Anda sudah masuk ke admin untuk diproses.');
    }

    /**
     * Batalkan pesanan
     * Hanya boleh jika status masih pending.
     * Stok produk akan dikembalikan.
     */
    public function cancel(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        // Transaction agar pengembalian stok + ubah status aman
        DB::transaction(function () use ($order) {
            // Kembalikan stok setiap item
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)
                        ->increment('stock', $item->quantity);
                }
            }

            // Ubah status jadi cancelled
            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Ubah metode pembayaran (hanya jika masih pending)
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
