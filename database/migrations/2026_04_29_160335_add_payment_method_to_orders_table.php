<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('status');
            }
            if (!Schema::hasColumn('orders', 'payment_data')) {
                $table->json('payment_data')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'midtrans_transaction_id')) {
                $table->string('midtrans_transaction_id')->nullable()->after('payment_data');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_data', 'midtrans_transaction_id']);
        });
    }
};
