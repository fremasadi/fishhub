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
        Schema::table('stok_benihs', function (Blueprint $table) {
            $table->integer('harga')->nullable()->after('jumlah'); // atau decimal sesuai kebutuhan
            $table->string('image')->nullable()->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_benih', function (Blueprint $table) {
            //
        });
    }
};
