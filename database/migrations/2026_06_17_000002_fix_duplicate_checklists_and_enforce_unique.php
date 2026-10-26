<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus semua duplikat - simpan hanya ID terbesar per (lks_id, document_id)
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

        // Unique constraint sudah ada dari migration awal, tidak perlu recreate
        // (drop/recreate gagal karena ada foreign key constraint)
    }

    public function down(): void
    {
        // tidak ada yang perlu di-rollback
    }
};
