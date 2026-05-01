<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->enum('kewenangan_type', ['kabkota', 'provinsi', 'kemensos'])
                  ->default('kabkota')
                  ->after('status_permohonan');
        });
    }

    public function down(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->dropColumn('kewenangan_type');
        });
    }
};
