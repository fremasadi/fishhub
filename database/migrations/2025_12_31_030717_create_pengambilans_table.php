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
        Schema::create('pengambilans', function (Blueprint $table) {
            $table->id();

    // Relasi
    $table->foreignId('pesanan_id')
        ->constrained('pesanans')
        ->cascadeOnDelete();

    $table->foreignId('pembudidaya_id')
        ->constrained('users')
        ->cascadeOnDelete();

    $table->foreignId('peternak_id')
        ->constrained('peternaks')
        ->cascadeOnDelete();

    // Data pengambilan
    $table->dateTime('tanggal_pengambilan')->nullable();

    $table->enum('status_pengambilan', [
        'Menunggu',     // otomatis setelah pembayaran berhasil
        'Siap Diambil', // peternak konfirmasi
        'Diserahkan',   // peternak menyerahkan
        'Diterima',     // pembudidaya konfirmasi
        'Dibatalkan'
    ])->default('Menunggu');

    $table->string('bukti_serah')->nullable(); // foto / upload
    $table->text('catatan')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengambilans');
    }
};
