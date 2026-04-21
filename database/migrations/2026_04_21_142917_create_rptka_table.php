<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rptka', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lks', 200);
            $table->string('nama_tka_pemohon', 200);
            $table->text('alamat_lks');
            $table->enum('permohonan_rptka', ['Baru', 'Ulang']);
            $table->date('tanggal_masuk_dokumen');
            $table->date('tanggal_persyaratan_lengkap')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rptka');
    }
};

