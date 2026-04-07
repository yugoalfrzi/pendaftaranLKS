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
            $table->dropcolumn('alasan_penolakan');
            $table->dropcolumn('alasan_dikembalikan');
            $table->dropcolumn('nomor_kontak');
            $table->dropcolumn('verifikator');
            $table->dropcolumn('nama_verifikator');
            $table->dropcolumn('tandatangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->text('alasan_penolakan')->nullable();
            $table->text('alasan_dikembalikan')->nullable();
            $table->string('nomor_kontak')->nullable();
            $table->string('verifikator')->nullable();
            $table->string('nama_verifikator')->nullable();
            $table->string('tandatangan')->nullable();
        });
    }
};
