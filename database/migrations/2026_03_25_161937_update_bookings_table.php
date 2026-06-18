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
        Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->string('order_id')->unique();
    $table->string('customer_name');
    $table->string('customer_email');
    $table->string('customer_phone');
    $table->date('visit_date');
    $table->string('session');
    $table->unsignedBigInteger('total_amount');
    $table->string('payment_type')->nullable();
    $table->enum('status', ['pending','paid','cancelled','fraud'])->default('pending');
    $table->json('items');
    $table->timestamp('paid_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
