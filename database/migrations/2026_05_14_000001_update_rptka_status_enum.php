<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing data first
        DB::statement("UPDATE rptka SET status_permohonan = 'Terekomendasi' WHERE status_permohonan = 'Diterima'");
        DB::statement("UPDATE rptka SET status_permohonan = 'Disetujui' WHERE status_permohonan = 'Terverifikasi'");

        // Alter enum to new values
        DB::statement("ALTER TABLE rptka MODIFY COLUMN status_permohonan ENUM('Menunggu','Terekomendasi','Disetujui','Ditolak','Dikembalikan') NOT NULL DEFAULT 'Menunggu'");
    }

    public function down(): void
    {
        // Revert data
        DB::statement("UPDATE rptka SET status_permohonan = 'Diterima' WHERE status_permohonan = 'Terekomendasi'");
        DB::statement("UPDATE rptka SET status_permohonan = 'Terverifikasi' WHERE status_permohonan = 'Disetujui'");

        // Revert enum
        DB::statement("ALTER TABLE rptka MODIFY COLUMN status_permohonan ENUM('Menunggu','Diterima','Ditolak','Dikembalikan','Terverifikasi') NOT NULL DEFAULT 'Menunggu'");
    }
};
