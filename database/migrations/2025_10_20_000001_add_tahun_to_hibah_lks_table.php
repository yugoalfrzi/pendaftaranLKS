<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('hibah_lks', function (Blueprint $table) {
			// Use small integer for year and index it for filtering
			$table->unsignedSmallInteger('tahun')->default((int) date('Y'))->after('nama_lks')->index();
		});
	}

	public function down(): void
	{
		Schema::table('hibah_lks', function (Blueprint $table) {
			$table->dropIndex(['tahun']);
			$table->dropColumn('tahun');
		});
	}
};



