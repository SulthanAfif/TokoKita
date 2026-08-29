<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart()->with('items.product')->firstOrFail();
        $addresses = Auth::user()->addresses;

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        return view('checkout.index', compact('cart', 'addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|string',
        ]);

        $cart = Auth::user()->cart()->with('items.product')->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Gunakan DB transaction: kalau ada error di tengah proses,
        // semua perubahan akan dibatalkan (rollback) agar data tetap konsisten.
        $order = DB::transaction(function () use ($request, $cart) {
            $subtotal = $cart->items->sum(fn ($item) => $item->product->final_price * $item->quantity);
            $shippingCost = 15000; // Contoh ongkir flat, bisa diganti kalkulasi dinamis

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id' => Auth::id(),
                'address_id' => $request->address_id,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $subtotal + $shippingCost,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->final_price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->final_price * $item->quantity,
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }

            // Kosongkan keranjang setelah order berhasil dibuat
            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat!');
    }
}
