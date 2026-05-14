<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing data first
        DB::statement("UPDATE lks SET status_permohonan = 'Terekomendasi' WHERE status_permohonan IN ('Diterima untuk proses', 'Diterima')");
        DB::statement("UPDATE lks SET status_permohonan = 'Menunggu' WHERE status_permohonan = 'Menunggu kelengkapan data'");

        // Alter enum to new values
        DB::statement("ALTER TABLE lks MODIFY COLUMN status_permohonan ENUM('Menunggu','Terekomendasi','Disetujui','Ditolak','Dikembalikan') NOT NULL DEFAULT 'Menunggu'");
    }

    public function down(): void
    {
        // Revert data
        DB::statement("UPDATE lks SET status_permohonan = 'Diterima' WHERE status_permohonan = 'Terekomendasi'");
        DB::statement("UPDATE lks SET status_permohonan = 'Diterima' WHERE status_permohonan = 'Disetujui'");

        // Revert enum
        DB::statement("ALTER TABLE lks MODIFY COLUMN status_permohonan ENUM('Diterima untuk proses','Diterima','Menunggu kelengkapan data','Menunggu','Dikembalikan','Ditolak') NOT NULL DEFAULT 'Menunggu'");
    }
};
