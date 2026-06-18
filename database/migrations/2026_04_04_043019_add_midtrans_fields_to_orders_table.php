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
        $table->string('snap_token')->nullable()->after('status');
        $table->string('payment_type')->nullable()->after('snap_token');
        $table->string('midtrans_transaction_id')->nullable()->after('payment_type');
        $table->string('payment_status')->nullable()->after('midtrans_transaction_id'); // pending, paid, failed, expired
        $table->json('midtrans_payload')->nullable()->after('payment_status');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn([
            'snap_token',
            'payment_type', 
            'midtrans_transaction_id',
            'payment_status',
            'midtrans_payload'
        ]);
    });
}
};
