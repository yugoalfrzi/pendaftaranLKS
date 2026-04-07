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
            $table->string('pusat_lks')->default('pusat')->after('alamat_lks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->dropColumn('pusat_lks');
        });
    }
};
