<?php

/**
 * Migration: add_role_and_phone_to_users_table
 * -------------------------------------------
 * Tambah kolom role (admin/customer) dan phone ke tabel users.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role: 'customer' (default) atau 'admin'
            $table->string('role')->default('customer')->after('email');
            $table->string('phone')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone']);
        });
    }
};
