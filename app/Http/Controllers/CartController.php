<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * CartController
 * --------------
 * Mengatur semua aksi terkait keranjang belanja:
 * - Lihat isi keranjang
 * - Tambah produk
 * - Ubah jumlah
 * - Hapus item
 */
class CartController extends Controller
{
    /**
     * Helper private: ambil keranjang user yang sedang login.
     * Jika belum punya keranjang, otomatis dibuat.
     */
    private function getOrCreateCart()
    {
        // Auth::user() = user yang sedang login
        // cart() = relasi HasOne di model User
        // firstOrCreate([]) = cari, kalau belum ada → create baru
        return Auth::user()->cart()->firstOrCreate([]);
    }

    /**
     * Tampilkan halaman keranjang (/keranjang)
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();

        // Load relasi items + product di dalam setiap item (eager loading)
        $cart->load('items.product');

        return view('cart.index', compact('cart'));
    }

    /**
     * Tambah produk ke keranjang
     * Route: POST /keranjang/{product}
     */
    public function add(Request $request, Product $product)
    {
        // Validasi quantity (opsional, minimal 1)
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $quantity = $request->input('quantity', 1); // default 1 jika tidak dikirim

        // Cari item yang sudah ada di keranjang untuk produk ini
        // firstOrNew = jika belum ada, buat instance baru (belum disimpan)
        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);

        // Jika item sudah ada → tambahkan quantity-nya
        // Jika baru → quantity = $quantity
        $item->quantity = ($item->exists ? $item->quantity : 0) + $quantity;
        $item->save();

        // Kembali ke halaman sebelumnya + pesan sukses
        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    /**
     * Ubah jumlah item di keranjang
     * Route: PATCH /keranjang/item/{item}
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();

        // Cari item milik keranjang ini saja (keamanan)
        $item = $cart->items()->findOrFail($itemId);

        // Update quantity
        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    /**
     * Hapus item dari keranjang
     * Route: DELETE /keranjang/item/{item}
     */
    public function remove($itemId)
    {
        $cart = $this->getOrCreateCart();

        // Hapus item (hanya milik keranjang user ini)
        $cart->items()->findOrFail($itemId)->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
