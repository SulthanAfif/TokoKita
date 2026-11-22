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
                $table->string('snap_token')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'midtrans_order_id')) {
                $table->string('midtrans_order_id')->nullable()->after('snap_token');
            }
            if (!Schema::hasColumn('orders', 'midtrans_transaction_id')) {
                $table->string('midtrans_transaction_id')->nullable()->after('midtrans_order_id');
            }
            if (!Schema::hasColumn('orders', 'payment_type')) {
                $table->string('payment_type')->nullable()->after('midtrans_transaction_id');
            }
        });
    }

    public function down(): void
    {
        $ran = app('migration.repository')->getRan();
        $columns = [];

        if (!in_array('2026_09_23_000001_add_midtrans_fields_to_orders_table', $ran, true)) {
            $columns = ['snap_token', 'midtrans_transaction_id', 'payment_type'];
        }

        if (!in_array('2026_09_23_000002_add_midtrans_order_id_to_orders', $ran, true)) {
            $columns[] = 'midtrans_order_id';
        }

        if ($columns !== []) {
            Schema::table('orders', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
