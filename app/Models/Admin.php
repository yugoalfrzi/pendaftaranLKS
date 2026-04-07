<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = [
        'nama_verifikator',
        'verifikator',
        'nomor_kontak',
        'tandatangan',
        'nama_lks',
        'alamat_lks',
        'nama_ketua_lks',
        'jenis_pelayanan',
        'jumlah_binaan_dalam_panti',
        'jumlah_binaan_luar_panti',
        'pusat_lks',
        'cabang_lks',
        'nomor_kontak',
        'tanda_pendaftaran',
        'tanggal_masuk_dokumen',
        'tanggal_persyaratan',
        'pendaftaran_lengkap',
        'status_permohonan',
        'alasan_penolakan',
        'alasan_dikembalikan',
        'sertifikat_path'
    ];
}
