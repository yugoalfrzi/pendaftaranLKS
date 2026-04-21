<?php
// database/seeders/MasterDocumentSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterDocument;

class MasterDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            // ========== DOKUMEN UTAMA (urutan 1-9) ==========
            [
                'nama_dokumen' => 'Rencana Penggunaan Tenaga Kerja Asing (RPTKA)',
                'deskripsi' => 'Dokumen rencana penggunaan TKA yang diajukan oleh LKS',
                'wajib' => true,
                'kategori' => 'utama',
                'urutan' => 1,
            ],
            [
                'nama_dokumen' => 'Permohonan Rekomendasi dari LKS ke Dinas Sosial Provinsi Jawa Barat',
                'deskripsi' => 'Surat permohonan rekomendasi yang ditujukan ke Dinsos Jabar',
                'wajib' => true,
                'kategori' => 'utama',
                'urutan' => 2,
            ],
            [
                'nama_dokumen' => 'Surat Rekomendasi dari Dinas Sosial kabupaten/kota tempat LKS tersebut beroperasi',
                'deskripsi' => 'Rekomendasi dari Dinsos kab/kota tempat LKS beroperasi',
                'wajib' => true,
                'kategori' => 'utama',
                'urutan' => 3,
            ],
            [
                'nama_dokumen' => 'Surat Keterangan Domisili Lembaga (terbaru) dari Kepala Desa/Lurah setempat',
                'deskripsi' => 'SK domisili terbaru dari Kepala Desa/Lurah setempat',
                'wajib' => true,
                'kategori' => 'utama',
                'urutan' => 4,
            ],
            [
                'nama_dokumen' => 'Akta Pendirian',
                'deskripsi' => 'Akta pendirian LKS/Yayasan',
                'wajib' => true,
                'kategori' => 'utama',
                'urutan' => 5,
            ],
            [
                'nama_dokumen' => 'Pengesahan Pendirian sebagai Badan Hukum oleh Kementerian yang Menyelenggarakan urusan pemerintah di bidang hukum',
                'deskripsi' => 'Pengesahan dari Kementerian Hukum',
                'wajib' => true,
                'kategori' => 'utama',
                'urutan' => 6,
            ],
            [
                'nama_dokumen' => 'Struktur organisasi LKS (Yayasan)',
                'deskripsi' => 'Struktur organisasi lengkap',
                'wajib' => true,
                'kategori' => 'utama',
                'urutan' => 7,
            ],
            [
                'nama_dokumen' => 'Surat penunjukan pendamping TKA',
                'deskripsi' => 'Surat penunjukan pendamping untuk TKA',
                'wajib' => true,
                'kategori' => 'utama',
                'urutan' => 8,
            ],
            [
                'nama_dokumen' => 'Tanda Pendaftaran sebagai LKS dari Dinas Sosial Kab/Kota yang menjadi Wilayah Kerja Provinsi (lebih dari 1 Kab/Kota) dan masih berlaku',
                'deskripsi' => 'Tanda daftar LKS yang masih berlaku',
                'wajib' => true,
                'kategori' => 'utama',
                'urutan' => 9,
            ],
            // ========== DOKUMEN PERPANJANGAN (urutan 10-12) ==========
            [
                'nama_dokumen' => 'Laporan Pelaksanaan Pendidikan dan Pelatihan',
                'deskripsi' => 'Laporan pelaksanaan diklat untuk perpanjangan RPTKA',
                'wajib' => true,
                'kategori' => 'perpanjangan',
                'urutan' => 10,
            ],
            [
                'nama_dokumen' => 'Keputusan RPTKA yang masih berlaku',
                'deskripsi' => 'Keputusan RPTKA sebelumnya yang masih aktif',
                'wajib' => true,
                'kategori' => 'perpanjangan',
                'urutan' => 11,
            ],
            [
                'nama_dokumen' => 'Izin Menggunakan Tenaga Asing (IMTA) yang masih berlaku',
                'deskripsi' => 'IMTA sebelumnya yang masih aktif',
                'wajib' => true,
                'kategori' => 'perpanjangan',
                'urutan' => 12,
            ],
        ];

        foreach ($documents as $doc) {
            MasterDocument::updateOrCreate(
                ['urutan' => $doc['urutan']],
                $doc
            );
        }
    }
}
