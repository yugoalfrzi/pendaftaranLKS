<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('checklists', function (Blueprint $table) {
            // Hapus kolom lama jika ada
            if (Schema::hasColumn('checklists', 'file_path')) {
                $table->dropColumn('file_path');
            }
            if (Schema::hasColumn('checklists', 'original_filename')) {
                $table->dropColumn('original_filename');
            }
            
            // Tambah kolom baru untuk multiple files
            $table->json('file_paths')->nullable()->after('keterangan');
            $table->json('original_filenames')->nullable()->after('file_paths');
            $table->integer('file_count')->default(0)->after('original_filenames');
        });
    }

    public function down()
    {
        Schema::table('checklists', function (Blueprint $table) {
            $table->dropColumn(['file_paths', 'original_filenames', 'file_count']);
            
            // Kembalikan kolom lama
            $table->string('file_path')->nullable();
            $table->string('original_filename')->nullable();
        });
    }
};