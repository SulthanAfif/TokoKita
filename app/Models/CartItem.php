<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model CartItem
 * --------------
 * Mewakili 1 baris item di dalam keranjang.
 * Contoh: "Kaos Polos Hitam × 2"
 */
class CartItem extends Model
{
    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'cart_id',      // ID keranjang (foreign key)
        'product_id',   // ID produk
        'quantity',     // Jumlah yang dibeli
    ];

    /**
     * Item ini milik 1 keranjang
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Item ini merujuk ke 1 produk
     * Contoh: $item->product->name
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor: hitung subtotal item ini
     * Dipanggil: $item->subtotal
     * = harga final produk × quantity
     */
    public function getSubtotalAttribute(): float
    {
        return $this->product->final_price * $this->quantity;
    }
}
