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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();

            // FK
            $table->unsignedBigInteger('pembudidaya_id');
            $table->unsignedBigInteger('peternak_id')->nullable(); 
            $table->unsignedBigInteger('stok_id')->nullable(); // stok awal (boleh null karena pakai detail)

            $table->date('tanggal_pesan');
            $table->double('total_harga')->default(0);

            $table->enum('status_pesanan', [
                'Menunggu',
                'Dibayar',
                'Selesai',
                'Dibatalkan'
            ])->default('Menunggu');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('pembudidaya_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('peternak_id')->references('id')->on('peternaks')->onDelete('set null');
            $table->foreign('stok_id')->references('stok_id')->on('stok_benihs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
