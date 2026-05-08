<?php

namespace App\Http\Controllers;

use App\Models\LKS;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    public function pendingUsers()
    {
        $pendingUsers = User::where('approval_status', 'pending')
            ->where('role', 'user')
            ->latest()
            ->get();
        return view('superadmin.pending-users', compact('pendingUsers'));
    }

    /**
     * Display a listing of LKS for super admin
     */
    public function index(Request $request)
    {
        // Hanya tampilkan LKS kewenangan PROVINSI yang sudah diverifikasi admin
        // (sudah ada surat rekomendasi & status Diterima untuk proses) — kabkota berhenti di admin
        $query = LKS::with('user')
            ->where('status_permohonan', 'Diterima untuk proses')
            ->whereNotNull('surat_rekomendasi_path')
            ->where('kewenangan_type', 'provinsi')
            // Sembunyikan data yang sudah diverifikasi super admin lebih dari 24 jam
            ->where(function($q) {
                $q->whereNull('verified_at')
                  ->orWhere('verified_at', '>=', now()->subHours(24));
            });

        // Filter by status tanda pendaftaran
        if ($request->has('has_sertifikat')) {
            if ($request->has_sertifikat == 'yes') {
                // Sudah ada tanda pendaftaran (sudah diproses super admin)
                $query->whereNotNull('sertifikat_path');
            } elseif ($request->has_sertifikat == 'no') {
                // Belum ada tanda pendaftaran (baru dari admin)
                $query->whereNull('sertifikat_path');
            }
        }

        // Filter by kabupaten/kota
        if ($request->has('kabupaten') && $request->kabupaten != '') {
            $query->where('kabupaten_kota', 'like', '%' . $request->kabupaten . '%');
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lks', 'like', "%{$search}%")
                  ->orWhere('alamat_lks', 'like', "%{$search}%")
                  ->orWhere('nomor_kontak', 'like', "%{$search}%");
            });
        }

        $lks = $query->latest()->paginate(15);
        
        // Calculate statistics (hanya untuk kewenangan provinsi)
        $stats = [
            'total'          => LKS::where('kewenangan_type', 'provinsi')->where('status_permohonan', 'Diterima untuk proses')->whereNotNull('surat_rekomendasi_path')->count(),
            'menunggu'       => LKS::where('kewenangan_type', 'provinsi')->where('status_permohonan', 'Diterima untuk proses')->whereNotNull('surat_rekomendasi_path')->whereNull('sertifikat_path')->count(),
            'diterima_proses'=> LKS::where('kewenangan_type', 'provinsi')->where('status_permohonan', 'Diterima untuk proses')->count(),
            'diterima'       => LKS::where('kewenangan_type', 'provinsi')->where('status_permohonan', 'Diterima')->count(),
            'terverifikasi'  => LKS::where('kewenangan_type', 'provinsi')->where('status_permohonan', 'Terverifikasi')->count(),
            'ditolak'        => LKS::where('kewenangan_type', 'provinsi')->where('status_permohonan', 'Ditolak')->count(),
            'dikembalikan'   => LKS::where('kewenangan_type', 'provinsi')->where('status_permohonan', 'Dikembalikan')->count(),
            'with_sertifikat'=> LKS::where('kewenangan_type', 'provinsi')->where('status_permohonan', 'Diterima')->whereNotNull('sertifikat_path')->count(),
        ];
        
        return view('superadmin.index', compact('lks', 'stats'));
    }

    /**
     * Show verification form for super admin
     */
    public function verification($id)
    {
        $lks = LKS::with(['checklists.document', 'user'])->findOrFail($id);
        
        // Hanya LKS provinsi yang bisa diproses super admin
        if ($lks->kewenangan_type !== 'provinsi') {
            return redirect()->route('superadmin.index')
                ->with('error', 'LKS ini bukan kewenangan provinsi.');
        }

        // Cek apakah sudah ada surat rekomendasi dari admin
        if (!$lks->surat_rekomendasi_path || $lks->status_permohonan != 'Diterima untuk proses') {
            return redirect()->route('superadmin.index')
                ->with('error', 'LKS ini belum memiliki surat rekomendasi dari admin. Tidak dapat upload tanda pendaftaran.');
        }
        
        return view('superadmin.verification', compact('lks'));
    }

    /**
     * Process verification and upload tanda pendaftaran
     */
    public function processVerification(Request $request, $id)
    {
        $lks = LKS::findOrFail($id);

        $request->validate([
            'status_permohonan'   => 'required|in:Diterima untuk proses,Ditolak,Dikembalikan',
            'alasan_penolakan'    => 'required_if:status_permohonan,Ditolak',
            'alasan_dikembalikan' => 'required_if:status_permohonan,Dikembalikan',
            'sertifikat'          => 'nullable|file|mimes:pdf|max:5120',
            'verifikator'         => 'required',
            'nama_verifikator'    => 'required',
        ]);

        // Handle tanda pendaftaran upload (dari super admin)
        if ($request->hasFile('sertifikat')) {
            if ($lks->sertifikat_path) {
                Storage::disk('public')->delete($lks->sertifikat_path);
            }

            $file = $request->file('sertifikat');
            $filename = 'sertifikat_' . $lks->id . '_' . time() . '.pdf';
            $path = $file->storeAs('sertifikat', $filename, 'public');
            $lks->sertifikat_path = $path;

            // Saat tanda pendaftaran diupload → otomatis "Diterima"
            $lks->status_permohonan   = 'Diterima';
            $lks->alasan_penolakan    = null;
            $lks->alasan_dikembalikan = null;
            $lks->verifikator_id      = $request->verifikator;
            $lks->nama_verifikator    = $request->nama_verifikator;
            $lks->verified_at         = now();
            $lks->save();

            return redirect()->route('superadmin.index')
                ->with('success', 'Tanda pendaftaran berhasil diupload. Status LKS diubah ke "Diterima".');
        }

        // Jika tidak ada upload tanda pendaftaran (Ditolak / Dikembalikan)
        $lks->status_permohonan   = $request->status_permohonan;
        $lks->alasan_penolakan    = $request->alasan_penolakan;
        $lks->alasan_dikembalikan = $request->alasan_dikembalikan;
        $lks->verifikator_id      = $request->verifikator;
        $lks->nama_verifikator    = $request->nama_verifikator;
        $lks->verified_at         = now();
        $lks->save();

        return redirect()->route('superadmin.index')
            ->with('success', 'Verifikasi berhasil diproses');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $lks = LKS::with('user')->findOrFail($id);
        
        return view('superadmin.edit', compact('lks'));
    }

    /**
     * Update LKS data
     */
    public function update(Request $request, $id)
    {
        $lks = LKS::findOrFail($id);

        $request->validate([
            'nama_lks' => 'required|string|max:255',
            'alamat_lks' => 'required|string',
            'nomor_kontak' => 'nullable|string|max:20',
            'kabupaten_kota' => 'nullable|string|max:255',
            'lokasi_lks' => 'nullable|string|max:255',
            'status_permohonan' => 'required|in:Menunggu,Diterima untuk proses,Diterima,Ditolak,Dikembalikan',
        ]);

        $lks->update($request->only([
            'nama_lks',
            'alamat_lks',
            'nomor_kontak',
            'kabupaten_kota',
            'lokasi_lks',
            'status_permohonan',
        ]));

        return redirect()->route('superadmin.index')
            ->with('success', 'Data LKS berhasil diperbarui');
    }

    /**
     * Delete LKS
     */
    public function destroy($id)
    {
        $lks = LKS::findOrFail($id);
        
        // Delete surat rekomendasi if exists
        if ($lks->sertifikat_path) {
            Storage::disk('public')->delete($lks->sertifikat_path);
        }
        
        $lks->delete();

        return redirect()->route('superadmin.index')
            ->with('success', 'Data LKS berhasil dihapus');
    }

    /**
     * Download tanda pendaftaran
     */
    public function downloadSuratRekomendasi($id)
    {
        $lks = LKS::findOrFail($id);

        if (!$lks->sertifikat_path || !Storage::disk('public')->exists($lks->sertifikat_path)) {
            abort(404, 'Tanda pendaftaran tidak ditemukan');
        }

        /** @var \Illuminate\Contracts\Filesystem\Filesystem $disk */
        $disk = Storage::disk('public');
        return $disk->download($lks->sertifikat_path);
    }

    /**
     * Preview tanda pendaftaran
     */
    public function previewSuratRekomendasi($id)
    {
        $lks = LKS::findOrFail($id);

        if (!$lks->sertifikat_path || !Storage::disk('public')->exists($lks->sertifikat_path)) {
            abort(404, 'Tanda pendaftaran tidak ditemukan');
        }

        /** @var \Illuminate\Contracts\Filesystem\Filesystem $disk */
        $disk = Storage::disk('public');
        $file = $disk->get($lks->sertifikat_path);
        $mimeType = $disk->mimeType($lks->sertifikat_path);

        return response($file, 200)->header('Content-Type', $mimeType);
    }

    /**
     * Delete tanda pendaftaran
     */
    public function deleteSuratRekomendasi($id)
    {
        $lks = LKS::findOrFail($id);

        if ($lks->sertifikat_path && Storage::disk('public')->exists($lks->sertifikat_path)) {
            Storage::disk('public')->delete($lks->sertifikat_path);
            $lks->sertifikat_path = null;
            $lks->save();
        }

        return redirect()->back()->with('success', 'Tanda pendaftaran berhasil dihapus');
    }

    /**
     * Download surat rekomendasi (untuk super admin melihat file dari admin)
     */
    public function downloadSuratRekomendasiAdmin($id)
    {
        $lks = LKS::findOrFail($id);

        if (!$lks->surat_rekomendasi_path || !Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            abort(404, 'Surat rekomendasi tidak ditemukan');
        }

        /** @var \Illuminate\Contracts\Filesystem\Filesystem $disk */
        $disk = Storage::disk('public');
        return $disk->download($lks->surat_rekomendasi_path);
    }

    /**
     * Preview surat rekomendasi (untuk super admin melihat file dari admin)
     */
    public function previewSuratRekomendasiAdmin($id)
    {
        $lks = LKS::findOrFail($id);

        if (!$lks->surat_rekomendasi_path || !Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            abort(404, 'Surat rekomendasi tidak ditemukan');
        }

        /** @var \Illuminate\Contracts\Filesystem\Filesystem $disk */
        $disk = Storage::disk('public');
        $file = $disk->get($lks->surat_rekomendasi_path);
        $mimeType = $disk->mimeType($lks->surat_rekomendasi_path);

        return response($file, 200)->header('Content-Type', $mimeType);
    }
}
