<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->string('kota_asal')->nullable()->after('no_telepon');
        $table->string('sesi')->nullable()->after('kota_asal');
        $table->json('items')->nullable()->after('sesi');
        
        // GANTI 'tanggal' MENJADI 'tanggal_kunjungan'
        $table->string('tanggal_kunjungan')->nullable()->after('items'); 
        
        // PASTIKAN kolom-kolom ini juga sudah ada di tabel orders kamu:
        // order_code, nama_pemesan, email, no_telepon, total_bayar, status, snap_token
    });
}
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'kota_asal', 'sesi', 'items', 'tanggal']);
        });
    }
};