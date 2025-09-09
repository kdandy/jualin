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
        // Add dokumentasi_public_id to barang_masuks table
        Schema::table('barang_masuks', function (Blueprint $table) {
            $table->string('dokumentasi_public_id')->nullable()->after('dokumentasi');
        });

        // Add dokumen_public_id to penjualans table
        Schema::table('penjualans', function (Blueprint $table) {
            $table->string('dokumen_public_id')->nullable()->after('dokumentasi');
        });

        // Add dokumentasi_public_id to log_sheet_harians table
        Schema::table('log_sheet_harians', function (Blueprint $table) {
            $table->string('dokumentasi_public_id')->nullable()->after('dokumentasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_masuks', function (Blueprint $table) {
            $table->dropColumn('dokumentasi_public_id');
        });

        Schema::table('penjualans', function (Blueprint $table) {
            $table->dropColumn('dokumen_public_id');
        });

        Schema::table('log_sheet_harians', function (Blueprint $table) {
            $table->dropColumn('dokumentasi_public_id');
        });
    }
};
