<?php

namespace Tests\Feature;

use App\Models\LKS;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LKSPerluTindakanTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_only_their_needs_action_lks(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
        ]);

        $otherUser = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
        ]);

        LKS::create([
            'user_id' => $user->id,
            'nama_lks' => 'LKS Saya Ditolak',
            'alamat_lks' => 'Jl. User 1',
            'kabupaten_kota' => 'Bandung',
            'lokasi_lks' => 'Bandung',
            'nomor_kontak' => '081111111111',
            'tanda_pendaftaran' => 'Baru',
            'tanggal_masuk_dokumen' => '2026-01-10',
            'tanggal_persyaratan' => '2026-01-12',
            'status_permohonan' => 'Ditolak',
            'kewenangan_type' => 'kabkota',
            'alasan_penolakan' => 'Dokumen tidak lengkap',
        ]);

        LKS::create([
            'user_id' => $otherUser->id,
            'nama_lks' => 'LKS Orang Lain',
            'alamat_lks' => 'Jl. User 2',
            'kabupaten_kota' => 'Jakarta',
            'lokasi_lks' => 'Jakarta',
            'nomor_kontak' => '082222222222',
            'tanda_pendaftaran' => 'Baru',
            'tanggal_masuk_dokumen' => '2026-01-11',
            'tanggal_persyaratan' => '2026-01-13',
            'status_permohonan' => 'Ditolak',
            'kewenangan_type' => 'kabkota',
            'alasan_penolakan' => 'Bukan milik saya',
        ]);

        $response = $this->actingAs($user)
            ->get(route('lks.perlu-tindakan'));

        $response->assertOk();
        $response->assertSee('LKS Saya Ditolak');
        $response->assertDontSee('LKS Orang Lain');
    }

    public function test_admin_verification_queue_hides_processed_lks(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
            'kabupaten_kota' => 'Bandung',
        ]);

        $pending = LKS::create([
            'user_id' => $admin->id,
            'nama_lks' => 'LKS Menunggu Verifikasi',
            'alamat_lks' => 'Jl. Admin 1',
            'kabupaten_kota' => 'Bandung',
            'lokasi_lks' => 'Bandung',
            'nomor_kontak' => '083333333333',
            'tanda_pendaftaran' => 'Baru',
            'tanggal_masuk_dokumen' => '2026-02-10',
            'tanggal_persyaratan' => '2026-02-12',
            'status_permohonan' => 'Menunggu',
            'kewenangan_type' => 'kabkota',
        ]);

        $approved = LKS::create([
            'user_id' => $admin->id,
            'nama_lks' => 'LKS Sudah Diterima',
            'alamat_lks' => 'Jl. Admin 2',
            'kabupaten_kota' => 'Bandung',
            'lokasi_lks' => 'Bandung',
            'nomor_kontak' => '084444444444',
            'tanda_pendaftaran' => 'Baru',
            'tanggal_masuk_dokumen' => '2026-02-11',
            'tanggal_persyaratan' => '2026-02-13',
            'status_permohonan' => 'Disetujui',
            'kewenangan_type' => 'kabkota',
        ]);

        $needsAction = LKS::create([
            'user_id' => $admin->id,
            'nama_lks' => 'LKS Perlu Tindakan',
            'alamat_lks' => 'Jl. Admin 3',
            'kabupaten_kota' => 'Bandung',
            'lokasi_lks' => 'Bandung',
            'nomor_kontak' => '085555555555',
            'tanda_pendaftaran' => 'Baru',
            'tanggal_masuk_dokumen' => '2026-02-12',
            'tanggal_persyaratan' => '2026-02-14',
            'status_permohonan' => 'Ditolak',
            'kewenangan_type' => 'kabkota',
            'alasan_penolakan' => 'Perlu revisi',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.lks.index'));

        $response->assertOk();
        $response->assertSee($pending->nama_lks);
        $response->assertDontSee($approved->nama_lks);
        $response->assertDontSee($needsAction->nama_lks);
    }
}
