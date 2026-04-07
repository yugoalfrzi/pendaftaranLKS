<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->string('cabang_lks')->default('cabang')->after('pusat_lks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->dropColumn('cabang_lks');
        });
    }
};
