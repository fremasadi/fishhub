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
        Schema::create('stok_benihs', function (Blueprint $table) {
    $table->id('stok_id');
    $table->unsignedBigInteger('peternak_id');
    $table->string('jenis'); // string, bukan FK
    $table->integer('jumlah');
    $table->string('ukuran');
    $table->string('kualitas');
    $table->enum('status_validasi', ['Menunggu', 'Terverifikasi'])->default('Menunggu');
    $table->enum('status_stok', ['Tersedia', 'Habis'])->default('Tersedia');
    $table->date('tanggal_input');
    $table->timestamps();

    // FK hanya ke peternaks
    $table->foreign('peternak_id')->references('id')->on('peternaks')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_benihs');
    }
};
