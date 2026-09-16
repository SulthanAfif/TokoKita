<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * CheckoutController
 * ------------------
 * Mengatur proses checkout:
 * 1. Tampilkan form checkout (pilih alamat + metode bayar)
 * 2. Buat pesanan baru + kurangi stok + kosongkan keranjang
 */
class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     * Route: GET /checkout
     */
    public function index()
    {
        // Ambil keranjang user + load item & produknya
        $cart = Auth::user()->cart()->with('items.product')->firstOrFail();

        // Ambil semua alamat yang dimiliki user
        $addresses = Auth::user()->addresses;

        // Jika keranjang kosong, tendang balik ke halaman keranjang
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        return view('checkout.index', compact('cart', 'addresses'));
    }

    /**
     * Proses membuat pesanan
     * Route: POST /checkout
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'address_id'     => 'required|exists:addresses,id', // Harus ada di tabel addresses
            'payment_method' => 'required|string',
        ]);

        // Ambil keranjang lagi (dengan relasi)
        $cart = Auth::user()->cart()->with('items.product')->firstOrFail();

        // Double-check keranjang tidak kosong
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        /**
         * DB Transaction sangat penting di sini!
         * Kalau ada error di tengah proses (misalnya stok tidak cukup),
         * semua perubahan akan di-rollback → data tetap konsisten.
         */
        $order = DB::transaction(function () use ($request, $cart) {

            // Hitung subtotal = Σ (harga final × quantity)
            $subtotal = $cart->items->sum(function ($item) {
                return $item->product->final_price * $item->quantity;
            });

            // Ongkir flat (bisa diganti logika dinamis nanti)
            $shippingCost = 15000;

            // Buat record Order
            $order = Order::create([
                'order_number'   => 'ORD-' . strtoupper(Str::random(10)), // Nomor unik
                'user_id'        => Auth::id(),
                'address_id'     => $request->address_id,
                'subtotal'       => $subtotal,
                'shipping_cost'  => $shippingCost,
                'total'          => $subtotal + $shippingCost,
                'status'         => 'pending',              // Status awal
                'payment_method' => $request->payment_method,
            ]);

            // Buat OrderItem untuk setiap produk di keranjang
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,          // Simpan nama (jaga-jaga produk dihapus)
                    'price'        => $item->product->final_price,   // Harga saat order dibuat
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->product->final_price * $item->quantity,
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }

            // Setelah order berhasil, kosongkan keranjang
            $cart->items()->delete();

            // Kembalikan objek order (akan ditangkap di luar transaction)
            return $order;
        });

        // Redirect ke halaman detail pesanan + pesan sukses
        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}
