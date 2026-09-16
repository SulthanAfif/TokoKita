<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_orders_table + order_items
 * --------------------------------------------
 * Tabel pesanan customer.
 *
 * Status alur:
 * pending → paid → processing → shipped → completed
 *                ↘ cancelled
 *
 * order_items menyimpan snapshot nama & harga produk
 * agar riwayat order tidak berubah walau produk diedit/dihapus.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Tabel pesanan
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();                          // Nomor unik (ORD-XXXX)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();    // Siapa yang pesan
            $table->foreignId('address_id')->nullable()->constrained()->nullOnDelete(); // Alamat kirim
            $table->decimal('subtotal', 12, 2);                                // Total harga barang
            $table->decimal('shipping_cost', 12, 2)->default(0);               // Ongkir
            $table->decimal('total', 12, 2);                                   // subtotal + ongkir

            // Status pesanan
            // pending    = menunggu pembayaran
            // paid       = sudah dibayar
            // processing = sedang diproses admin
            // shipped    = sudah dikirim
            // completed  = selesai
            // cancelled  = dibatalkan
            $table->enum('status', [
                'pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'
            ])->default('pending');

            $table->string('payment_method')->nullable();  // transfer_bank / e_wallet / cod
            $table->timestamp('paid_at')->nullable();      // Waktu pembayaran
            $table->timestamps();
        });

        // Tabel detail item pesanan
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

            // Snapshot: simpan nama & harga saat order dibuat
            // Agar riwayat tidak berubah jika produk diedit/dihapus nanti
            $table->string('product_name');
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
