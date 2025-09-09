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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_barang');
            $table->decimal('qty', 10, 2);
            $table->string('satuan');
            $table->decimal('stok_awal', 10, 2);
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('total_penjualan', 15, 2);
            $table->decimal('laba', 15, 2);
            $table->decimal('stok_akhir', 10, 2);
            $table->string('dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
