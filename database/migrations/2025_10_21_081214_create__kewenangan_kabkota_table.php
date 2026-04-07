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
        Schema::create('kewenangan_kabkota', function (Blueprint $table) {
            $table->id();
            $table->text('Nama_Lembaga_Yayasan');
            $table->enum('status', ['pusat', 'cabang']);
            $table->string('kabupaten_kota');
            $table->text('alamat');
            $table->string('ketua_yayasan');
            $table->string('no')->nullable();
            $table->text('nama_lks');
            $table->string('pusat_cabang');
            $table->string('kabupaten_kota_lks');
            $table->text('alamat_lks');
            // Nama pengurus LKS
            $table->string('nama_ketua_lks');
            $table->string('nama_sekretaris');
            $table->string('nama_bendahara');
            //akta pendirian yayasan (akta notaris)
            $table->text('nama_notaris');
            $table->string('nomor_notaris');
            $table->date('tanggal_akta');
            //PENGESAHAN PENDIRIAN YAYASAN
            $table->string('nomor_pengesahan');
            $table->date('tanggal_pengesahan');
            //npwp
            $table->text('nama_npwp');
            $table->string('nomor_npwp');
            $table->enum('status_bangunan', ['milik_sendiri', 'sewa/kontrak','wakaf']);
            $table->enum('akreditasi', ['a', 'b', 'c', 'tidak_terakreditasi']);
            //tanda daftar kabupaten/kota
            $table->string('nomor_tandaDaftar');
            $table->date('tanggal_tandaDaftar');
            $table->text('jenis_pelayanan_PPKS');
            //jumlah warga binaan
            $table->integer('jumlah_seluruh_binaan');
            $table->integer('jumlah_dalam_panti');
            $table->integer('jumlah_luar_panti');
            //jumlah ppks
            $table->integer('anak_balita_terlantar_DP');
            $table->integer('anak_balita_terlantar_LP');
            $table->integer('anak_terlantar_DP');
            $table->integer('anak_terlantar_LP');
            $table->integer('anak_yangberhadapan_dengan_hukum_DP');
            $table->integer('anak_yangberhadapan_dengan_hukum_LP');
            $table->integer('anak_jalanan_DP');
            $table->integer('anak_jalanan_LP');
            $table->integer('anak_dengan_kedisabilitas_DP');
            $table->integer('anak_dengan_kedisabilitas_LP');
            $table->integer('anak_yangmenjadi_tidak_kekerasan_DP');
            $table->integer('anak_yangmenjadi_tidak_kekerasan_LP');
            $table->integer('anak_yang_memerlukan_perlindungan_khusus_DP');
            $table->integer('anak_yang_memerlukan_perlindungan_khusus_LP');
            $table->integer('lanjut_usia_terlantar_DP');
            $table->integer('lanjut_usia_terlantar_LP');
            $table->integer('disabilitas_fisik_DP');
            $table->integer('disabilitas_fisik_LP');
            $table->integer('disabilitas_intelektual_DP');
            $table->integer('disabilitas_intelektual_LP');
            $table->integer('disabilitas_mental_DP');
            $table->integer('disabilitas_mental_LP');
            $table->integer('disabilitas_sensorik_DP');
            $table->integer('disabilitas_sensorik_LP');
            $table->integer('tuna_susila_DP');
            $table->integer('tuna_susila_LP');
            $table->integer('gelandangan_DP');
            $table->integer('gelandangan_LP');
            $table->integer('pengemis_DP');
            $table->integer('pengemis_LP');
            $table->integer('pemulung_DP');
            $table->integer('pemulung_LP');
            $table->integer('kelompok_minoritas_DP');
            $table->integer('kelompok_minoritas_LP');
            $table->integer('BWBLP_DP');
            $table->integer('BWBLP_LP');
            $table->integer('orang_dengan_hiv_aids_DP');
            $table->integer('orang_dengan_hiv_aids_LP');
            $table->integer('penyalahgunaan_Napza_DP');
            $table->integer('penyalahgunaan_Napza_LP');
            $table->integer('korban_Trafficking_DP');
            $table->integer('korban_Trafficking_LP');
            $table->integer('korban_tindak_kekerasan_DP');
            $table->integer('korban_tindak_kekerasan_LP');
            $table->integer('PMBS_DP');
            $table->integer('PMBS_LP');
            $table->integer('korban_bencana_alam_DP');
            $table->integer('korban_bencana_alam_LP');
            $table->integer('korban_bencana_sosial_DP');
            $table->integer('korban_bencana_sosial_LP');
            $table->integer('perempuan_rawan_sosial_ekonomi_DP');   
            $table->integer('perempuan_rawan_sosial_ekonomi_LP');
            $table->integer('fakir_miskin_DP');
            $table->integer('fakir_miskin_LP');
            $table->integer('keluarga_bermasalah_sosial_psikologis_DP'); 
            $table->integer('keluarga_bermasalah_sosial_psikologis_LP');
            $table->integer('komunitas_adat_terpencil_DP');
            $table->integer('komunitas_adat_terpencil_LP');
            //kontak person
            $table->string('nomor_tlp');
            $table->string('email');
            $table->string('link_tanda_daftar')->nullable();
            $table->timestamps();
            



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kewenangan_kabkota');
    }
};
