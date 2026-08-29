<?php

namespace Tests\Feature;

use App\Models\LKS;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SuperAdminVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_submit_verification_without_manual_verifier_field(): void
    {
        Storage::fake('public');

        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $lks = LKS::create([
            'user_id' => User::factory()->create()->id,
            'nama_lks' => 'LKS Test',
            'alamat_lks' => 'Jl. Test No. 1',
            'kabupaten_kota' => 'Bandung',
            'lokasi_lks' => 'Bandung',
            'nomor_kontak' => '081234567890',
            'status_permohonan' => 'Terekomendasi',
            'kewenangan_type' => 'provinsi',
            'surat_rekomendasi_path' => 'surat_rekomendasi/test.pdf',
            'nama_verifikator' => null,
            'verifikator_id' => null,
        ]);

        $pdf = UploadedFile::fake()->create('sertifikat.pdf', 120, 'application/pdf');

        $response = $this->actingAs($superAdmin)
            ->from(route('superadmin.verification', $lks->id))
            ->post(route('superadmin.verification.process', $lks->id), [
                'status_permohonan' => 'Terekomendasi',
                'verifikator' => $superAdmin->id,
                'nama_verifikator' => $superAdmin->name,
                'sertifikat' => $pdf,
            ]);

        $response->assertRedirect(route('superadmin.index'));
        $response->assertSessionHas('success');

        $lks->refresh();
        $this->assertEquals('Disetujui', $lks->status_permohonan);
        $this->assertEquals($superAdmin->id, $lks->verifikator_id);
        $this->assertEquals($superAdmin->name, $lks->nama_verifikator);
    }
}
