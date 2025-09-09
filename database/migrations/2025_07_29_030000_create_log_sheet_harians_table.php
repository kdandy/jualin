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
        Schema::create('log_sheet_harians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('media')->nullable();
            $table->decimal('suhu', 5, 2); // Suhu Ruang/Wadah
            $table->decimal('kelembapan', 5, 2); // Kelembapan Ruang/Wadah
            $table->decimal('berat_limbah', 8, 2); // Berat limbah
            $table->string('fase_kehidupan'); // Fase Kehidupan
            $table->string('jenis_sampah')->nullable(); // Jenis sampah (bisa null)
            $table->decimal('berat_kasgot', 8, 2); // Berat kasgot
            $table->string('dokumentasi')->nullable(); // File dokumentasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_sheet_harians');
    }
};