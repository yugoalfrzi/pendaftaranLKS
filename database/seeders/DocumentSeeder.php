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
            ['nama_dokumen' => 'Surat Permohonan dari LKS kepada Gubernur Jawa Barat melalui Dinsos Provinsi Jawa Barat (secara tertulis)', 'deskripsi' => 'Dokumen permohonan LKS', 'wajib' => true, 'urutan' => 1],
            ['nama_dokumen' => 'Anggaran Dasar dan Anggaran Rumah Tangga', 'deskripsi' => 'Anggaran dasar dan rumah tangga', 'wajib' => true, 'urutan' => 2],
            ['nama_dokumen' => 'Akta Pendirian', 'deskripsi' => 'Akta Pendirian LKS', 'wajib' => true, 'urutan' => 3],
            ['nama_dokumen' => 'Surat Keterangan Domisili Lembaga (terbaru) dari Kepala Desa/Lurah setempat', 'deskripsi' => 'Dokumen keterangan domisili', 'wajib' => true, 'urutan' => 4],
            ['nama_dokumen' => 'NPWP Badan Hukum lembaga', 'deskripsi' => 'Nomor Pokok Wajib Pajak badan hukum', 'wajib' => true, 'urutan' => 5],
            ['nama_dokumen' => 'Pengesahan Pendirian sebagai Badan Hukum oleh Kementerian yang menyelenggarakan urusan pemerintah di bidang hukum', 'deskripsi' => 'Dokumen pengesahan pendirian', 'wajib' => true, 'urutan' => 6],
            ['nama_dokumen' => 'Struktur Organisasi LKS', 'deskripsi' => 'Struktur organisasi LKS', 'wajib' => true, 'urutan' => 7],
            ['nama_dokumen' => 'BNBA (By Name By Address)', 'deskripsi' => 'BNBA', 'wajib' => true, 'urutan' => 8],
            ['nama_dokumen' => 'Daftar Nama Pengurus LKS (Nama, alamat dan No. Telp)', 'deskripsi' => 'Nama, alamat dan no. telp', 'wajib' => true, 'urutan' => 9],
            ['nama_dokumen' => 'KTP Pengurus LKS', 'deskripsi' => 'KTP pengurus LKS', 'wajib' => true, 'urutan' => 10],
            ['nama_dokumen' => 'Surat Keterangan bebas dari Narkoba bagi Pengurus LKS', 'deskripsi' => 'Surat keterangan bebas narkoba pengurus LKS', 'wajib' => true, 'urutan' => 11],
            ['nama_dokumen' => 'Surat Pernyataan tidak dalam sengketa kepengurusan atau tidak dalam perkara di Pengadilan', 'deskripsi' => 'Surat pernyataan tidak dalam sengketa', 'wajib' => true, 'urutan' => 12],
            ['nama_dokumen' => 'Surat Pernyataan kesanggupan melaporkan kegiatan', 'deskripsi' => 'Surat pernyataan kesanggupan', 'wajib' => true, 'urutan' => 13],
            ['nama_dokumen' => 'Surat Pernyataan bahwa sumber pendanaan tidak berasal dari kegiatan melawan hukum dan tidak digunakan untuk kegiatan yang melawan hukum', 'deskripsi' => 'Surat pernyataan sumber pendanaan', 'wajib' => true, 'urutan' => 14],
            ['nama_dokumen' => 'Surat Pernyataan Persetujuan Tetangga', 'deskripsi' => 'Surat pernyataan persetujuan tetangga', 'wajib' => true, 'urutan' => 15],
            ['nama_dokumen' => 'Proposal', 'deskripsi' => 'Berisi program kegiatan, modal kerja, nomor rekening LKS, SDM dan kelengkapan sarana prasarana', 'wajib' => true, 'urutan' => 16],
            ['nama_dokumen' => 'Tanda Pendaftaran sebelumnya dari Dinas Sosial Kabupaten Kota', 'deskripsi' => 'Tanda Pendaftaran sebelumnya', 'wajib' => true, 'urutan' => 17],
            ['nama_dokumen' => 'Tanda Pendaftaran sebagai LKS dari Dinas Sosial Kab/Kota yang menjadi Wilayah Kerja Provinsi (lebih dari 1 Kab/Kota) dan masih berlaku.', 'deskripsi' => 'Tanda daftar sebagai LKS dari Dinas Sosial Kab/Kota', 'wajib' => true, 'urutan' => 18],
            ['nama_dokumen' => 'Surat Rekomendasi dari Dinas Sosial Kabupaten/Kota Setempat', 'deskripsi' => 'Surat rekomendasi Dinas Sosial Kabupaten/Kota', 'wajib' => true, 'urutan' => 19],
            ['nama_dokumen' => 'Tanda Pendaftaran sebelumnya dari Dinas Sosial Provinsi Jawa Barat', 'deskripsi' => 'Tanda pendaftaran dari Dinas Sosial Provinsi Jawa Barat', 'wajib' => true, 'urutan' => 20],
        ];

        // Hapus semua dokumen lama dulu, lalu insert ulang yang bersih
        // Cari ID dokumen yang ada duplikat, ambil ID terkecil per urutan
        $validIds = \Illuminate\Support\Facades\DB::table('documents')
            ->select(\Illuminate\Support\Facades\DB::raw('MIN(id) as id'), 'urutan')
            ->groupBy('urutan')
            ->pluck('id')
            ->toArray();

        // Hapus semua dokumen yang bukan valid (duplikat)
        if (!empty($validIds)) {
            \App\Models\Document::whereNotIn('id', $validIds)->delete();
        }

        // updateOrCreate berdasarkan urutan — tidak akan duplikat
        foreach ($documents as $doc) {
            Document::updateOrCreate(
                ['urutan' => $doc['urutan']],
                [
                    'nama_dokumen' => $doc['nama_dokumen'],
                    'deskripsi'    => $doc['deskripsi'],
                    'wajib'        => $doc['wajib'],
                ]
            );
        }
    }
}
