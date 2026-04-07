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
        Schema::table('lks', function (Blueprint $table) {
            $table->string('nama_ketua_lks')->default('ketua')->after('alamat_lks');
            $table->string('jenis_pelayanan')->default('pelayanan')->after('nama_ketua_lks');
            $table->string('jumlah_binaan_dalam_panti')->default('jumlah_binaan')->after('jenis_pelayanan');
            $table->string('jumlah_binaan_luar_panti')->default('jumlah_binaan')->after('jumlah_binaan_dalam_panti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->dropColumn('nama_ketua_lks');
            $table->dropColumn('jenis_pelayanan');
            $table->dropColumn('jumlah_binaan_dalam_panti');
            $table->dropColumn('jumlah_binaan_luar_panti');
        });
    }
};
