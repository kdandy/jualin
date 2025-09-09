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
        Schema::create('penjualans_maggot', function (Blueprint $table) {
            $table->id();
            $table->string('no')->unique();
            $table->date('tanggal');
            $table->string('produk');
            $table->integer('qty');
            $table->decimal('harga', 15, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans_maggot');
    }
};
