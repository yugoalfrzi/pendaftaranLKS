<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_size')->nullable();
            $table->string('file_type'); // pdf, doc, docx, ppt, pptx
            $table->enum('announcement_type', ['panduan', 'regulasi', 'surat']);
            $table->string('category');
            $table->string('format'); // PDF, DOCX, DOC, PPT, PPTX
            $table->string('icon')->nullable();
            $table->integer('download_count')->default(0);
            $table->integer('year')->nullable();
            $table->date('last_updated')->nullable();
            $table->string('type')->nullable(); // untuk surat: Pengajuan, Permohonan, dll
            $table->date('date')->nullable(); // untuk surat
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['announcement_type', 'is_active']);
            $table->index('category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
};