<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Expand enum to include both old and new values
        DB::statement("ALTER TABLE lks MODIFY COLUMN status_permohonan ENUM('Diterima untuk proses','Diterima','Menunggu kelengkapan data','Menunggu','Dikembalikan','Ditolak','Terekomendasi','Disetujui') NOT NULL DEFAULT 'Menunggu'");

        // Step 2: Migrate existing data to new values
        DB::statement("UPDATE lks SET status_permohonan = 'Terekomendasi' WHERE status_permohonan IN ('Diterima untuk proses', 'Diterima')");
        DB::statement("UPDATE lks SET status_permohonan = 'Menunggu' WHERE status_permohonan = 'Menunggu kelengkapan data'");

        // Step 3: Remove old values from enum
        DB::statement("ALTER TABLE lks MODIFY COLUMN status_permohonan ENUM('Menunggu','Terekomendasi','Disetujui','Ditolak','Dikembalikan') NOT NULL DEFAULT 'Menunggu'");
    }

    public function down(): void
    {
        // Step 1: Expand enum
        DB::statement("ALTER TABLE lks MODIFY COLUMN status_permohonan ENUM('Menunggu','Terekomendasi','Disetujui','Ditolak','Dikembalikan','Diterima untuk proses','Diterima','Menunggu kelengkapan data') NOT NULL DEFAULT 'Menunggu'");

        // Step 2: Revert data
        DB::statement("UPDATE lks SET status_permohonan = 'Diterima' WHERE status_permohonan = 'Terekomendasi'");
        DB::statement("UPDATE lks SET status_permohonan = 'Diterima' WHERE status_permohonan = 'Disetujui'");

        // Step 3: Remove new values from enum
        DB::statement("ALTER TABLE lks MODIFY COLUMN status_permohonan ENUM('Diterima untuk proses','Diterima','Menunggu kelengkapan data','Menunggu','Dikembalikan','Ditolak') NOT NULL DEFAULT 'Menunggu'");
    }
};
