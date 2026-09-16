<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_carts_table + cart_items
 * ------------------------------------------
 * Tabel keranjang belanja.
 *
 * carts      → 1 user punya 1 keranjang (user_id unique)
 * cart_items → isi keranjang (produk + quantity)
 *
 * Constraint unik: 1 produk hanya 1 baris per cart
 * (kalau ditambah lagi, quantity-nya yang di-update)
 */
return new class extends Migration
{
    public function up(): void
    {
        // Tabel keranjang (1 per user)
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete(); // 1 user = 1 cart
            $table->timestamps();
        });

        // Tabel item di dalam keranjang
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();     // FK ke carts
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();  // FK ke products
            $table->unsignedInteger('quantity')->default(1);                    // Jumlah
            $table->timestamps();

            // 1 produk hanya boleh muncul 1 baris per cart
            $table->unique(['cart_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
