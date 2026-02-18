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
            $table->unsignedBigInteger('stok_id')
                  ->nullable()
                  ->after('id'); // sesuaikan posisi kolom jika perlu

            $table->foreign('stok_id')
                  ->references('id') // biasanya PK stok_benihs = id
                  ->on('stok_benihs')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            //
        });
    }
};
