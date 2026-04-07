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
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('nama_verifikator');
            $table->string('verifikator');
            $table->string('nomor_kontak');
            $table->string('tandatangan')->nullable();
            $table->string('nama_lks');
            $table->text('alamat_lks');
            $table->enum('tanda_pendaftaran', ['Baru', 'Ulang']);
            $table->date('tanggal_masuk_dokumen');
            $table->date('tanggal_persyaratan');
            $table->boolean('pendaftaran_lengkap')->default(false);
            $table->enum('status_permohonan', [
                'Diterima untuk proses',
                'Diterima',
                'Menunggu kelengkapan data',
                'Menunggu',
                'Dikembalikan',
                'Ditolak'
            ])->default('Menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->text('alasan_dikembalikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
