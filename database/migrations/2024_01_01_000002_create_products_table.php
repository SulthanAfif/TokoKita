<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_products_table
 * --------------------------------
 * Membuat tabel produk toko.
 *
 * Relasi:
 * - category_id → categories (foreign key, cascade delete)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();                                                    // Primary key
            $table->foreignId('category_id')->constrained()->cascadeOnDelete(); // FK ke categories
            $table->string('name');                                          // Nama produk
            $table->string('slug')->unique();                                // URL-friendly (unik)
            $table->text('description')->nullable();                         // Deskripsi panjang
            $table->decimal('price', 12, 2);                                 // Harga normal
            $table->decimal('discount_price', 12, 2)->nullable();            // Harga diskon (opsional)
            $table->unsignedInteger('stock')->default(0);                    // Stok tersedia
            $table->string('sku')->unique();                                 // Kode unik produk
            $table->string('thumbnail')->nullable();                         // Path/URL gambar utama
            $table->boolean('is_active')->default(true);                     // Tampil di toko?
            $table->timestamps();                                            // created_at & updated_at

            // Index untuk mempercepat query filter & pencarian
            $table->index(['is_active', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
