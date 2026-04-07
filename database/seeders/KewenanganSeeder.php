<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kewenangan;

class KewenanganSeeder extends Seeder
{
    public function run()
    {
        // Contoh data untuk kewenangan provinsi
        Kewenangan::create([
            'nama_yayasan' => 'YAYASAN WARGA UPADAYA',
            'status' => 'PUSAT',
            'kabupaten_kota' => 'Kota Bogor',
            'alamat_yayasan' => 'Jl. Pahlawan I No. 28 05/07 Kel. Bondongan Kec. Bogor Selatan',
            'ketua_yayasan' => 'Bernadetha Diah Insiyah',
            'nama_lks' => 'LKS. WARGA UPADAYA',
            'induk_cabang' => 'Pusat',
            'kabupaten_kota_lks' => 'Kota Bogor',
            'alamat_lks' => 'Jl. Pahlawan I No. 28 05/07 Kel. Bondongan Kec. Bogor Selatan',
            'jenis_pelayanan_ppks' => 'Anak Terlantar',
            'jumlah_warga_binaan_dalam_panti' => 0,
            'jumlah_warga_binaan_luar_panti' => 362,
            'level_kewenangan' => 'PROVINSI',
            'tanggal_terbit' => 'FEB'
        ]);

        // Tambahkan data lainnya sesuai kebutuhan
    }
}