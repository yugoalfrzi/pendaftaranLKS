<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('checklists', function (Blueprint $table) {
            // Hapus kolom lama jika masih ada
            if (Schema::hasColumn('checklists', 'file_path')) {
                $table->dropColumn('file_path');
            }
            if (Schema::hasColumn('checklists', 'original_filename')) {
                $table->dropColumn('original_filename');
            }
        });
    }

    public function down()
    {
        Schema::table('checklists', function (Blueprint $table) {
            // Kembalikan kolom lama (opsional)
            $table->string('file_path')->nullable();
            $table->string('original_filename')->nullable();
        });
    }
};