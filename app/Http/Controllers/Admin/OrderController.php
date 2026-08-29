<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'items'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
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

        // Ringkasan: total unit dari semua pesanan yang tampil (filter aktif)
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

    public function show(Order $order)
    {
        $order->load('user', 'items', 'address');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
            'paid_at' => $request->status === 'paid' && !$order->paid_at ? now() : $order->paid_at,
        ]);

        return back()->with('success', 'Status pesanan berhasil diubah menjadi: ' . $request->status);
    }
}
