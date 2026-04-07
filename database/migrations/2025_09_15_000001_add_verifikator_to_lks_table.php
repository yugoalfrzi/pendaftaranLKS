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
            $table->unsignedBigInteger('verifikator_id')->nullable()->after('status_permohonan');
            $table->string('nama_verifikator')->nullable()->after('verifikator_id');

            // Jika ingin relasi foreign key ke users/admin, aktifkan baris di bawah:
            // $table->foreign('verifikator_id')->references('id')->on('admin')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lks', function (Blueprint $table) {
            $table->dropColumn(['verifikator_id', 'nama_verifikator']);
        });
    }
};