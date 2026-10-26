<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Hapus semua duplikat - simpan hanya ID terbesar per (lks_id, document_id)
        $duplicates = DB::select("
            SELECT lks_id, document_id, MAX(id) as keep_id, COUNT(*) as cnt
            FROM checklists
            GROUP BY lks_id, document_id
            HAVING COUNT(*) > 1
        ");

        foreach ($duplicates as $dup) {
            DB::table('checklists')
                ->where('lks_id', $dup->lks_id)
                ->where('document_id', $dup->document_id)
                ->where('id', '!=', $dup->keep_id)
                ->delete();
        }

        // Step 2: Drop existing unique index jika ada, lalu recreate
        // (agar konsisten di semua environment)
        Schema::table('checklists', function (Blueprint $table) {
            // Drop jika sudah ada (pakai try-catch untuk keamanan)
            try {
                $table->dropUnique(['lks_id', 'document_id']);
            } catch (\Exception $e) {
                // Index mungkin belum ada atau nama berbeda, lanjutkan
            }
        });

        Schema::table('checklists', function (Blueprint $table) {
            // Recreate unique constraint
            $table->unique(['lks_id', 'document_id'], 'checklists_lks_id_document_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('checklists', function (Blueprint $table) {
            try {
                $table->dropUnique('checklists_lks_id_document_id_unique');
            } catch (\Exception $e) {
                // ignore
            }
        });
    }
};
