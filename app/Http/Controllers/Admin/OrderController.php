<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

/**
 * OrderController (Admin)
 * -----------------------
 * Mengelola pesanan dari sisi admin:
 * - Lihat daftar pesanan (filter status + search)
 * - Lihat detail pesanan
 * - Ubah status pesanan (pending → paid → processing → shipped → completed)
 */
class OrderController extends Controller
{
    /**
     * Daftar semua pesanan
     * Filter: ?status=pending | ?search=ORD-xxx atau nama customer
     */
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'items'])
            // Filter berdasarkan status
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            // Search: nomor order / nama customer / nama produk
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('order_number', 'like', '%' . $request->search . '%')
                      ->orWhereHas('user', fn ($u) => $u->where('name', 'like', '%' . $request->search . '%'))
                      ->orWhereHas('items', fn ($i) => $i->where('product_name', 'like', '%' . $request->search . '%'));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Hitung total unit terjual sesuai filter aktif
        $totalUnits = OrderItem::query()
            ->whereHas('order', function ($q) use ($request) {
                if ($request->status) {
                    $q->where('status', $request->status);
                } else {
                    $q->where('status', '!=', 'cancelled');
                }
            })
            ->sum('quantity');

        return view('admin.orders.index', compact('orders', 'totalUnits'));
    }

    /**
     * Detail 1 pesanan (user, items, alamat)
     */
    public function show(Order $order)
    {
        $order->load('user', 'items', 'address');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Ubah status pesanan
     * Jika status diubah ke "paid" dan belum ada paid_at → isi otomatis
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled',
        ]);

        $order->update([
            'status'  => $request->status,
            // Jika baru dibayar, catat waktu bayar
            'paid_at' => $request->status === 'paid' && !$order->paid_at
                ? now()
                : $order->paid_at,
        ]);

        return back()->with('success', 'Status pesanan berhasil diubah menjadi: ' . $request->status);
    }
}
