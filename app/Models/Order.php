<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Order (Pesanan)
 * ---------------------
 * Menyimpan data pesanan yang dibuat customer.
 * Status bisa: pending, paid, processing, shipped, completed, cancelled
 */
class Order extends Model
{
    /**
     * Kolom yang boleh diisi mass-assignment
     */
    protected $fillable = [
        'order_number',    // Nomor unik pesanan (contoh: ORD-A1B2C3D4E5)
        'user_id',         // Siapa yang memesan
        'address_id',      // Alamat pengiriman
        'subtotal',        // Total harga barang (belum ongkir)
        'shipping_cost',   // Biaya ongkir
        'total',           // subtotal + shipping_cost
        'status',          // Status pesanan
        'payment_method',  // transfer_bank / e_wallet / cod
        'paid_at',         // Kapan dibayar (null jika belum)
        'snap_token',      // Token Snap Midtrans untuk buka popup pembayaran
        'midtrans_order_id',       // order_id yang dikirim ke Midtrans
        'midtrans_transaction_id', // transaction_id dari Midtrans
        'payment_type',    // Jenis pembayaran yang dipilih user di Snap (gopay, bank_transfer, dll)
    ];

    /**
     * Casting: paid_at otomatis jadi objek Carbon (datetime)
     */
    protected $casts = [
        'paid_at' => 'datetime',
    ];

    // =========================================================
    // RELASI
    // =========================================================

    /**
     * Pesanan dimiliki oleh 1 user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Pesanan punya 1 alamat pengiriman
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Pesanan punya banyak item (produk yang dibeli)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
