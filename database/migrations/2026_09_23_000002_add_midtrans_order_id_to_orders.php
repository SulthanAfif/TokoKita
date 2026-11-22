<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'midtrans_order_id')) {
                $table->string('midtrans_order_id')->nullable()->after('snap_token');
            }
        });
    }

    public function down(): void
    {
        if (in_array('2026_09_23_063101_add_midtrans_fields_to_orders_table', app('migration.repository')->getRan(), true)) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'midtrans_order_id')) {
                $table->dropColumn('midtrans_order_id');
            }
        });
    }
};
