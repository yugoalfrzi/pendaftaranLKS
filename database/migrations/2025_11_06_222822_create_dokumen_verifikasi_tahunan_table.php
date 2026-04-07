<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumen_verifikasi_tahunan', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('tahun')->unique(); // Tahun unik
            $table->string('file_path'); // Path file verifikasi
            $table->string('nama_file'); // Nama asli file
            $table->string('uploaded_by'); // Yang mengupload
            $table->text('keterangan')->nullable(); // Keterangan dokumen
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_verifikasi_tahunan');
    }
};