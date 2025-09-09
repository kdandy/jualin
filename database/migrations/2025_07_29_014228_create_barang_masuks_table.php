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
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('pemasok');
            $table->string('nama_barang');
            $table->decimal('qty', 10, 2);
            $table->string('satuan')->default('kg'); // kg atau pcs
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('total_pembelian', 15, 2);
            $table->string('dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
