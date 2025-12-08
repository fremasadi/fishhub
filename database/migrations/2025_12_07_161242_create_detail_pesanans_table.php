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
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();

            // FK
            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('stok_id');

            $table->integer('qty')->default(1);
            $table->double('harga_satuan')->default(0);

            $table->timestamps();

            // Foreign Keys
            $table->foreign('pesanan_id')
                ->references('id')->on('pesanans')
                ->onDelete('cascade');

            $table->foreign('stok_id')
                ->references('stok_id')->on('stok_benihs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
