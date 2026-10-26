<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus duplikat checklist — hanya simpan record dengan id terbesar per (lks_id, document_id)
        $duplicates = DB::table('checklists')
            ->select('lks_id', 'document_id', DB::raw('MAX(id) as keep_id'))
            ->groupBy('lks_id', 'document_id')
            ->having(DB::raw('COUNT(*)'), '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            DB::table('checklists')
                ->where('lks_id', $dup->lks_id)
                ->where('document_id', $dup->document_id)
                ->where('id', '!=', $dup->keep_id)
                ->delete();
        }
    }

    public function down(): void
    {
        // tidak bisa di-rollback (data sudah terhapus)
    }
};
