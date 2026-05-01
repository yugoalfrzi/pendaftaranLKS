<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kabupaten_kota')->nullable()->after('phone');
            $table->index('kabupaten_kota');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['kabupaten_kota']);
            $table->dropColumn('kabupaten_kota');
        });
    }
};
