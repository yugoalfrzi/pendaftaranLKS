<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->string('sertifikat_path')->nullable()->after('nama_verifikator');
        });

        Schema::table('admin', function (Blueprint $table) {
            $table->string('sertifikat_path')->nullable()->after('alasan_dikembalikan');
        });
    }

    public function down()
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->dropColumn('sertifikat_path');
        });

        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('sertifikat_path');
        });
    }
};