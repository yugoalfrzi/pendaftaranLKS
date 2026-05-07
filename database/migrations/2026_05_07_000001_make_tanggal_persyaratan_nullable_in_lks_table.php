<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->date('tanggal_persyaratan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->date('tanggal_persyaratan')->nullable(false)->change();
        });
    }
};
