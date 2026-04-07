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
		Schema::create('hibah_lks', function (Blueprint $table) {
			$table->id();
			$table->string('nama_lks');
			// File paths (PDF) are nullable; store relative paths in storage
			$table->string('proposal_path')->nullable();
			$table->string('hasil_verifikasi_path')->nullable();
			$table->string('pergub_penjabaran_apbd_path')->nullable();
			$table->string('dpa_path')->nullable();
			$table->string('hasil_identifikasi_path')->nullable();
			$table->string('data_penerima_hibah_path')->nullable();
			$table->string('spm_path')->nullable();
			$table->string('sp2d_path')->nullable();
			$table->string('lpj_path')->nullable();
			$table->string('petunjuk_teknis_path')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('hibah_lks');
	}
};


