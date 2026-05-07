<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hibah_lks', function (Blueprint $table) {
            $table->string('surat_ket_lampiran_verifikasi_path')->nullable()->after('petunjuk_teknis_path');
            $table->string('bukti_pembayaran_transfer_path')->nullable()->after('surat_ket_lampiran_verifikasi_path');
            $table->string('sk_kadinsos_tim_verifikasi_path')->nullable()->after('bukti_pembayaran_transfer_path');
        });
    }

    public function down(): void
    {
        Schema::table('hibah_lks', function (Blueprint $table) {
            $table->dropColumn([
                'surat_ket_lampiran_verifikasi_path',
                'bukti_pembayaran_transfer_path',
                'sk_kadinsos_tim_verifikasi_path',
            ]);
        });
    }
};
