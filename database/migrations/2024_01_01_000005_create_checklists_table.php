<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('checklists', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lks_id')->constrained()->onDelete('cascade'); // Harus not null
        $table->foreignId('document_id')->constrained()->onDelete('cascade');
        $table->enum('kelengkapan', ['Ada', 'Tidak Ada'])->default('Tidak Ada');
        $table->text('keterangan')->nullable();
        $table->string('file_path')->nullable();
        $table->string('original_filename')->nullable();
        $table->timestamps();
        
        // Unique constraint untuk menghindari duplikasi
        $table->unique(['lks_id', 'document_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};
