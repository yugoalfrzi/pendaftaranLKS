<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documents = [
            [
                'nama_dokumen' => 'Anggaran Dasar dan Anggaran Rumah Tangga',
                'deskripsi' => 'Dokumen AD/ART LKS',
                'wajib' => true,
                'urutan' => 1,
            ],
            [
                'nama_dokumen' => 'Akta Pendirian',
                'deskripsi' => 'Akta pendirian LKS',
                'wajib' => true,
                'urutan' => 2,
            ],
            [
                'nama_dokumen' => 'Surat Keterangan Domisili Lembaga (terbaru) Dari Kepala Desa / Lurah setempat',
                'deskripsi' => 'Surat keterangan domisili terbaru',
                'wajib' => true,
                'urutan' => 3,
            ],
            [
                'nama_dokumen' => 'NPWP Badan Hukum LKS',
                'deskripsi' => 'Nomor Pokok Wajib Pajak badan hukum',
                'wajib' => true,
                'urutan' => 4,
            ],
            [
                'nama_dokumen' => 'Pengesahan Pendirian sebagai Badan Hukum oleh Kementerian yang menyelenggarakan urusan pemerintah di bidang hukum',
                'deskripsi' => 'Dokumen pengesahan badan hukum',
                'wajib' => true,
                'urutan' => 5,
            ],
            [
                'nama_dokumen' => 'Struktur Organisasi LKS',
                'deskripsi' => 'Struktur organisasi LKS',
                'wajib' => true,
                'urutan' => 6,
            ],
            [
                'nama_dokumen' => 'Alamat, No. Telp. Website dan Media Sosial LKS',
                'deskripsi' => 'Informasi kontak dan media sosial LKS',
                'wajib' => true,
                'urutan' => 7,
            ],
            [
                'nama_dokumen' => 'KTP dan No. Telp. Pengurus LKS',
                'deskripsi' => 'KTP dan nomor telepon pengurus',
                'wajib' => true,
                'urutan' => 8,
            ],
            [
                'nama_dokumen' => 'Surat Keterangan bebas dari Narkoba bagi Pengurus LKS',
                'deskripsi' => 'Surat keterangan bebas narkoba pengurus',
                'wajib' => true,
                'urutan' => 9,
            ],
            [
                'nama_dokumen' => 'Surat Pernyataan tidak dalam sengketa kepengurusan atau tidak dalam perkara di Pengadilan',
                'deskripsi' => 'Surat pernyataan tidak dalam sengketa',
                'wajib' => true,
                'urutan' => 10,
            ],
            [
                'nama_dokumen' => 'Surat Pernyataan kesanggupan melaporkan kegiatan',
                'deskripsi' => 'Surat pernyataan kesanggupan melaporkan kegiatan',
                'wajib' => true,
                'urutan' => 11,
            ],
            [
                'nama_dokumen' => 'Surat Pernyataan bahwa sumber pendanaan tidak berasal dari kegiatan melawan hukum dan tidak digunakan untuk kegiatan yang melawan hukum',
                'deskripsi' => 'Surat pernyataan sumber pendanaan',
                'wajib' => true,
                'urutan' => 12,
            ],
            [
                'nama_dokumen' => 'Surat Pernyataan Persetujuan Tetangga',
                'deskripsi' => 'Surat pernyataan persetujuan tetangga',
                'wajib' => true,
                'urutan' => 13,
            ],
            [
                'nama_dokumen' => 'Proposal Persyaratan :',
                'deskripsi' => ' Proposal program dan kegiatan LKS',
                'wajib' => true,
                'urutan' => 14,
            ],

            [
                'nama_dokumen' => 'Tanda Pendaftaran sebagai LKS dari Dinas Sosial Kab/Kota yang menjadi Wilayah Kerja Provinsi (lebih dari 1 Kab./Kota)',
                'deskripsi' => 'Tanda pendaftaran dari Dinas Sosial Kab/Kota',
                'wajib' => true,
                'urutan' => 15,
            ],
            [
                'nama_dokumen' => 'Surat Rekomendasi dari Dinas Sosial Kabupaten/Kota Setempat',
                'deskripsi' => 'Surat rekomendasi Dinas Sosial Kabupaten/Kota',
                'wajib' => true,
                'urutan' => 16,
            ],
        ];

        foreach ($documents as $document) {
            Document::create($document);
        }
    }
}
