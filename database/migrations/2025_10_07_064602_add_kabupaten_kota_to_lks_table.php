<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Import DB

return new class extends Migration
{
    public function up()
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->string('kabupaten_kota')->nullable()->after('lokasi_lks');
            
            // Optional: Add index for better performance
            $table->index('kabupaten_kota');
        });

        // Update existing records to populate kabupaten_kota from lokasi_lks
        DB::table('lks')
            ->whereNull('kabupaten_kota')
            ->whereNotNull('lokasi_lks')
            ->update(['kabupaten_kota' => DB::raw('lokasi_lks')]);
    }

    public function down()
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->dropColumn('kabupaten_kota');
        });
    }
};