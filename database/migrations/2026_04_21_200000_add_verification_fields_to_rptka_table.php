<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rptka', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('id');
            $table->enum('status_permohonan', [
                'Menunggu',
                'Diterima',
                'Ditolak',
                'Dikembalikan',
                'Terverifikasi',
            ])->default('Menunggu')->after('tanggal_persyaratan_lengkap');

            // Admin: surat rekomendasi RPTKA (berbeda dari surat_rekomendasi LKS)
            $table->string('surat_rekomendasi_rptka_path')->nullable()->after('status_permohonan');
            $table->string('alasan_penolakan')->nullable()->after('surat_rekomendasi_rptka_path');
            $table->string('alasan_dikembalikan')->nullable()->after('alasan_penolakan');
            $table->string('nama_verifikator')->nullable()->after('alasan_dikembalikan');

            // Super Admin: surat rekomendasi RPTKA final (hasil verval)
            $table->string('surat_rekomendasi_rptka_final_path')->nullable()->after('nama_verifikator');
            $table->string('nama_verifikator_superadmin')->nullable()->after('surat_rekomendasi_rptka_final_path');
        });
    }

    public function down(): void
    {
        Schema::table('rptka', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'status_permohonan',
                'surat_rekomendasi_rptka_path',
                'alasan_penolakan',
                'alasan_dikembalikan',
                'nama_verifikator',
                'surat_rekomendasi_rptka_final_path',
                'nama_verifikator_superadmin',
            ]);
        });
    }
};
