<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Ambil (atau buat) cart milik user yang sedang login
    private function getOrCreateCart()
    {
        return Auth::user()->cart()->firstOrCreate([]);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.product');

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $quantity = $request->input('quantity', 1);

        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        // Kalau produk sudah ada di cart, tambahkan quantity-nya
        $item->quantity = ($item->exists ? $item->quantity : 0) + $quantity;
        $item->save();

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = $this->getOrCreateCart();
        $item = $cart->items()->findOrFail($itemId);
        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove($itemId)
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->findOrFail($itemId)->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
