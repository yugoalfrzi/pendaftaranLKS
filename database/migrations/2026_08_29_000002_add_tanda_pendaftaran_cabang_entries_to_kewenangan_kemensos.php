<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kewenangan_kemensos', function (Blueprint $table) {
            if (!Schema::hasColumn('kewenangan_kemensos', 'tanda_pendaftaran_cabang_entries')) {
                $table->json('tanda_pendaftaran_cabang_entries')->nullable()->after('tanda_pendaftaran_cabang_tanggal');
            }
        });
    }

    public function down()
    {
        Schema::table('kewenangan_kemensos', function (Blueprint $table) {
            if (Schema::hasColumn('kewenangan_kemensos', 'tanda_pendaftaran_cabang_entries')) {
                $table->dropColumn('tanda_pendaftaran_cabang_entries');
            }
        });
    }
};
