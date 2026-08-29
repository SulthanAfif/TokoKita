<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // about, contact
            $table->string('title');
            $table->text('content')->nullable();
            $table->json('meta')->nullable(); // untuk kontak: email, phone, address
            $table->timestamps();
        });

        // Seed default content
        DB::table('pages')->insert([
            [
                'slug' => 'about',
                'title' => 'Tentang TokoKita',
                'content' => "TokoKita adalah platform e-commerce yang didesain untuk memberikan pengalaman belanja yang mudah, aman, dan menyenangkan. Kami menyediakan berbagai produk berkualitas dengan harga yang bersahabat.\n\nDari katalog produk yang lengkap, keranjang belanja yang praktis, hingga proses checkout yang cepat — semua dirancang agar kamu bisa belanja dengan nyaman dari mana saja.",
                'meta' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'contact',
                'title' => 'Hubungi Kami',
                'content' => 'Ada pertanyaan? Kami siap membantu.',
                'meta' => json_encode([
                    'email' => 'support@tokokita.com',
                    'phone' => '+62 812-3456-7890',
                    'address' => 'Jakarta, Indonesia',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
