<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rptka_document_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rptka_id')
                  ->constrained('rptka')
                  ->onDelete('cascade');
            $table->foreignId('master_document_id')
                  ->constrained('master_documents')
                  ->onDelete('cascade');
            $table->boolean('is_ada')->default(false);
            $table->text('keterangan')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->unique(['rptka_id', 'master_document_id'], 'unique_app_document');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rptka_document_status');
    }
};
