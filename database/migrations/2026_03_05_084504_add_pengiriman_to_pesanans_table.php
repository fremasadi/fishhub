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
        Schema::table('pesanans', function (Blueprint $table) {
            $table->enum('jenis_pengiriman', ['ambil_sendiri', 'diantar'])->default('ambil_sendiri')->after('status_pesanan');
            $table->text('alamat_pengiriman')->nullable()->after('jenis_pengiriman');
            $table->unsignedInteger('ongkir')->default(0)->after('alamat_pengiriman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['jenis_pengiriman', 'alamat_pengiriman', 'ongkir']);
        });
    }
};
