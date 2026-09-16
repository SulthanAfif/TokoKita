<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Cart (Keranjang Belanja)
 * ------------------------------
 * Setiap user yang login punya 1 keranjang.
 * Keranjang berisi banyak CartItem (produk + quantity).
 */
class Cart extends Model
{
    // Hanya user_id yang boleh diisi mass-assignment
    protected $fillable = ['user_id'];

    /**
     * Keranjang dimiliki oleh 1 user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Keranjang memiliki banyak item (produk)
     * Contoh: $cart->items
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Accessor: hitung total harga semua item di keranjang
     * Dipanggil: $cart->total
     *
     * Cara kerja:
     * - Loop setiap item
     * - Ambil final_price produk × quantity
     * - Jumlahkan semuanya
     */
    public function getTotalAttribute(): float
    {
        return $this->items->sum(function (CartItem $item) {
            return $item->product->final_price * $item->quantity;
        });
    }
}
