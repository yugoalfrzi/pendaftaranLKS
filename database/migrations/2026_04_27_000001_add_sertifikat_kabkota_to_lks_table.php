<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->string('sertifikat_kabkota_path')->nullable()->after('surat_rekomendasi_path');
        });
    }

    public function down(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->dropColumn('sertifikat_kabkota_path');
        });
    }
};
