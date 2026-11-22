<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('paid_at');
            }
            if (!Schema::hasColumn('orders', 'midtrans_transaction_id')) {
                $table->string('midtrans_transaction_id')->nullable()->after('snap_token');
            }
            if (!Schema::hasColumn('orders', 'payment_type')) {
                $table->string('payment_type')->nullable()->after('midtrans_transaction_id');
            }
        });
    }

    public function down(): void
    {
        if (in_array('2026_09_23_063101_add_midtrans_fields_to_orders_table', app('migration.repository')->getRan(), true)) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_transaction_id', 'payment_type']);
        });
    }
};
