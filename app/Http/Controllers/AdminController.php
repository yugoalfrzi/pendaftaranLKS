<?php

namespace App\Http\Controllers;

use App\Models\LKS;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function adminIndex(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $adminKabkota = auth()->user()->kabupaten_kota;

        // Query Kab/Kota — hanya tampilkan LKS dari kabupaten/kota admin yang login
        $queryKabkota = LKS::with('user')->where('kewenangan_type', 'kabkota');
        if ($adminKabkota) {
            $queryKabkota->where(function($q) use ($adminKabkota) {
                $q->where('kabupaten_kota', $adminKabkota)->orWhereNull('kabupaten_kota');
            });
        }
        // Sembunyikan data yang sudah diverifikasi lebih dari 24 jam
        $queryKabkota->where(function($q) {
            $q->whereNull('verified_at')
              ->orWhere('verified_at', '>=', now()->subHours(24));
        });
        if ($status) $queryKabkota->where('status_permohonan', $status);
        if ($search) $queryKabkota->where(fn($q) => $q->where('nama_lks', 'like', "%$search%")->orWhere('alamat_lks', 'like', "%$search%"));
        $lksKabkota = $queryKabkota->latest()->paginate(15, ['*'], 'kabkota_page');

        // Query Provinsi — hanya tampilkan LKS dari kabupaten/kota admin yang login
        $queryProvinsi = LKS::with('user')->where('kewenangan_type', 'provinsi');
        if ($adminKabkota) {
            $queryProvinsi->where(function($q) use ($adminKabkota) {
                $q->where('kabupaten_kota', $adminKabkota)->orWhereNull('kabupaten_kota');
            });
        }
        // Sembunyikan data yang sudah diverifikasi lebih dari 24 jam
        $queryProvinsi->where(function($q) {
            $q->whereNull('verified_at')
              ->orWhere('verified_at', '>=', now()->subHours(24));
        });
        if ($status) $queryProvinsi->where('status_permohonan', $status);
        if ($search) $queryProvinsi->where(fn($q) => $q->where('nama_lks', 'like', "%$search%")->orWhere('alamat_lks', 'like', "%$search%"));
        $lksProvinsi = $queryProvinsi->latest()->paginate(15, ['*'], 'provinsi_page');

        // Stats hanya untuk kabupaten/kota admin yang login
        $baseStats = LKS::query();
        if ($adminKabkota) {
            $baseStats->where(function($q) use ($adminKabkota) {
                $q->where('kabupaten_kota', $adminKabkota)->orWhereNull('kabupaten_kota');
            });
        }

        $stats = [
            'total'           => (clone $baseStats)->count(),
            'menunggu'        => (clone $baseStats)->where('status_permohonan', 'Menunggu')->count(),
            'diterima_proses' => (clone $baseStats)->where('status_permohonan', 'Diterima untuk proses')->count(),
            'diterima'        => (clone $baseStats)->where('status_permohonan', 'Diterima')->count(),
            'terverifikasi'   => (clone $baseStats)->where('status_permohonan', 'Terverifikasi')->count(),
            'ditolak'         => (clone $baseStats)->where('status_permohonan', 'Ditolak')->count(),
            'dikembalikan'    => (clone $baseStats)->where('status_permohonan', 'Dikembalikan')->count(),
            'with_sertifikat' => (clone $baseStats)->whereNotNull('surat_rekomendasi_path')->count(),
            'kabkota'         => (clone $baseStats)->where('kewenangan_type', 'kabkota')->count(),
            'provinsi'        => (clone $baseStats)->where('kewenangan_type', 'provinsi')->count(),
        ];

        return view('admin.index', compact('lksKabkota', 'lksProvinsi', 'stats'));
    }

    public function showVerification($id)
    {
        $lks = LKS::with(['checklists.document', 'user'])->findOrFail($id);
        return view('admin.verification', compact('lks'));
    }

    public function verification(Request $request, $id)
    {
        $lks = LKS::findOrFail($id);

        $rules = [
            'status_permohonan'   => 'required|in:Diterima,Ditolak,Dikembalikan',
            'alasan_penolakan'    => 'required_if:status_permohonan,Ditolak',
            'alasan_dikembalikan' => 'required_if:status_permohonan,Dikembalikan',
            'tanggal_persyaratan' => 'required_if:status_permohonan,Diterima|nullable|date',
            'surat_rekomendasi'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];

        // Tanda pendaftaran kabkota hanya untuk kewenangan kabkota
        if ($lks->kewenangan_type === 'kabkota') {
            $rules['sertifikat_kabkota'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        }

        $request->validate($rules);

        // Upload surat rekomendasi
        if ($request->hasFile('surat_rekomendasi')) {
            if ($lks->surat_rekomendasi_path) {
                Storage::disk('public')->delete($lks->surat_rekomendasi_path);
            }
            $file = $request->file('surat_rekomendasi');
            $filename = 'surat_rekomendasi_' . $lks->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $lks->surat_rekomendasi_path = $file->storeAs('surat_rekomendasi', $filename, 'public');

            // Provinsi: saat surat rekomendasi diupload → otomatis "Diterima untuk proses"
            if ($lks->kewenangan_type === 'provinsi' && $request->status_permohonan === 'Diterima') {
                $lks->status_permohonan = 'Diterima untuk proses';
                $lks->nama_verifikator  = auth()->user()?->name ?? 'Unknown';
                $lks->verified_at       = now();
                $lks->save();

                return redirect()->route('admin.lks.index')
                    ->with('success', 'Surat rekomendasi berhasil diupload. Status LKS diubah ke "Diterima untuk proses" dan diteruskan ke Super Admin.');
            }
        }

        // Upload tanda pendaftaran kabkota (khusus kewenangan kabkota)
        if ($lks->kewenangan_type === 'kabkota' && $request->hasFile('sertifikat_kabkota')) {
            if ($lks->sertifikat_kabkota_path) {
                Storage::disk('public')->delete($lks->sertifikat_kabkota_path);
            }
            $file = $request->file('sertifikat_kabkota');
            $filename = 'sertifikat_kabkota_' . $lks->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $lks->sertifikat_kabkota_path = $file->storeAs('sertifikat_kabkota', $filename, 'public');
        }

        $lks->status_permohonan   = $request->status_permohonan;
        $lks->alasan_penolakan    = $request->alasan_penolakan;
        $lks->alasan_dikembalikan = $request->alasan_dikembalikan;
        $lks->nama_verifikator    = auth()->user()?->name ?? 'Unknown';
        $lks->verified_at         = now();
        if ($request->status_permohonan === 'Diterima' && $request->filled('tanggal_persyaratan')) {
            $lks->tanggal_persyaratan = $request->tanggal_persyaratan;
        }
        $lks->save();

        return redirect()->route('admin.lks.index')
            ->with('success', 'Verifikasi berhasil diproses');
    }

    public function edit($id)
    {
        $lks = LKS::with('user')->findOrFail($id);
        return view('admin.edit', compact('lks'));
    }

    public function update(Request $request, $id)
    {
        $lks = LKS::findOrFail($id);
        $request->validate([
            'nama_lks'         => 'required|string|max:255',
            'alamat_lks'       => 'required|string',
            'status_permohonan'=> 'required',
        ]);
        $lks->update($request->only(['nama_lks', 'alamat_lks', 'nomor_kontak', 'kabupaten_kota', 'lokasi_lks', 'status_permohonan']));
        return redirect()->route('admin.lks.index')->with('success', 'Data LKS berhasil diperbarui');
    }

    public function show($id)
    {
        $lks = LKS::with(['checklists.document', 'user'])->findOrFail($id);
        return view('lks.show', compact('lks'));
    }

    public function destroy($id)
    {
        $lks = LKS::findOrFail($id);
        if ($lks->sertifikat_path) Storage::disk('public')->delete($lks->sertifikat_path);
        if ($lks->sertifikat_kabkota_path) Storage::disk('public')->delete($lks->sertifikat_kabkota_path);
        $lks->delete();
        return redirect()->route('admin.lks.index')->with('success', 'Data LKS berhasil dihapus');
    }

    // ===== Surat Rekomendasi =====
    public function downloadSertifikat($id)
    {
        $lks = LKS::findOrFail($id);
        if (!$lks->surat_rekomendasi_path || !Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            abort(404, 'Surat rekomendasi tidak ditemukan');
        }
        return Storage::disk('public')->download($lks->surat_rekomendasi_path);
    }

    public function previewSertifikat($id)
    {
        $lks = LKS::findOrFail($id);
        if (!$lks->surat_rekomendasi_path || !Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            abort(404, 'Surat rekomendasi tidak ditemukan');
        }
        $disk = Storage::disk('public');
        return response($disk->get($lks->surat_rekomendasi_path), 200)
            ->header('Content-Type', $disk->mimeType($lks->surat_rekomendasi_path));
    }

    public function deleteSertifikat($id)
    {
        $lks = LKS::findOrFail($id);
        if ($lks->surat_rekomendasi_path && Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            Storage::disk('public')->delete($lks->surat_rekomendasi_path);
            $lks->surat_rekomendasi_path = null;
            $lks->save();
        }
        return redirect()->back()->with('success', 'Surat rekomendasi berhasil dihapus');
    }

    // ===== Tanda Pendaftaran Kab/Kota =====
    public function downloadSertifikatKabkota($id)
    {
        $lks = LKS::findOrFail($id);
        if (!$lks->sertifikat_kabkota_path || !Storage::disk('public')->exists($lks->sertifikat_kabkota_path)) {
            abort(404, 'Tanda pendaftaran kab/kota tidak ditemukan');
        }
        return Storage::disk('public')->download($lks->sertifikat_kabkota_path);
    }

    public function previewSertifikatKabkota($id)
    {
        $lks = LKS::findOrFail($id);
        if (!$lks->sertifikat_kabkota_path || !Storage::disk('public')->exists($lks->sertifikat_kabkota_path)) {
            abort(404, 'Tanda pendaftaran kab/kota tidak ditemukan');
        }
        $disk = Storage::disk('public');
        return response($disk->get($lks->sertifikat_kabkota_path), 200)
            ->header('Content-Type', $disk->mimeType($lks->sertifikat_kabkota_path));
    }

    public function deleteSertifikatKabkota($id)
    {
        $lks = LKS::findOrFail($id);
        if ($lks->sertifikat_kabkota_path && Storage::disk('public')->exists($lks->sertifikat_kabkota_path)) {
            Storage::disk('public')->delete($lks->sertifikat_kabkota_path);
            $lks->sertifikat_kabkota_path = null;
            $lks->save();
        }
        return redirect()->back()->with('success', 'Tanda pendaftaran kab/kota berhasil dihapus');
    }

    public function verifyDocuments(Request $request, $id)
    {
        $lks = LKS::findOrFail($id);
        $lks->updatePendaftaranLengkap();
        return redirect()->back()->with('success', 'Status kelengkapan dokumen berhasil diperbarui');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,update_status',
            'ids'    => 'required|array',
            'status' => 'required_if:action,update_status',
        ]);
        if ($request->action === 'delete') {
            LKS::whereIn('id', $request->ids)->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        }
        if ($request->action === 'update_status') {
            LKS::whereIn('id', $request->ids)->update(['status_permohonan' => $request->status]);
            return redirect()->back()->with('success', 'Status berhasil diperbarui');
        }
        return redirect()->back();
    }

    // ===== PUBLIC: akses tanda pendaftaran untuk semua role =====

    private function checkLksAccess(lks $lks): void
    {
        // User hanya bisa akses miliknya; admin & super_admin bebas
        if (auth()->user()->role === 'user' && $lks->user_id !== auth()->id()) {
            abort(403);
        }
    }

    public function previewSertifikatKabkotaPublic($id)
    {
        $lks = LKS::findOrFail($id);
        $this->checkLksAccess($lks);

        if (!$lks->sertifikat_kabkota_path || !Storage::disk('public')->exists($lks->sertifikat_kabkota_path)) {
            abort(404, 'Tanda pendaftaran kab/kota tidak ditemukan');
        }
        $disk = Storage::disk('public');
        return response($disk->get($lks->sertifikat_kabkota_path), 200)
            ->header('Content-Type', $disk->mimeType($lks->sertifikat_kabkota_path));
    }

    public function downloadSertifikatKabkotaPublic($id)
    {
        $lks = LKS::findOrFail($id);
        $this->checkLksAccess($lks);

        if (!$lks->sertifikat_kabkota_path || !Storage::disk('public')->exists($lks->sertifikat_kabkota_path)) {
            abort(404, 'Tanda pendaftaran kab/kota tidak ditemukan');
        }
        return Storage::disk('public')->download($lks->sertifikat_kabkota_path);
    }

    public function previewSuratRekomendasiPublic($id)
    {
        $lks = LKS::findOrFail($id);
        $this->checkLksAccess($lks);

        if (!$lks->surat_rekomendasi_path || !Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            abort(404, 'Surat rekomendasi tidak ditemukan');
        }
        $disk = Storage::disk('public');
        return response($disk->get($lks->surat_rekomendasi_path), 200)
            ->header('Content-Type', $disk->mimeType($lks->surat_rekomendasi_path));
    }

    public function downloadSuratRekomendasiPublic($id)
    {
        $lks = LKS::findOrFail($id);
        $this->checkLksAccess($lks);

        if (!$lks->surat_rekomendasi_path || !Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            abort(404, 'Surat rekomendasi tidak ditemukan');
        }
        return Storage::disk('public')->download($lks->surat_rekomendasi_path);
    }

    public function previewSertifikatProvinsiPublic($id)
    {
        $lks = LKS::findOrFail($id);
        $this->checkLksAccess($lks);

        if (!$lks->sertifikat_path || !Storage::disk('public')->exists($lks->sertifikat_path)) {
            abort(404, 'Tanda pendaftaran provinsi tidak ditemukan');
        }
        $disk = Storage::disk('public');
        return response($disk->get($lks->sertifikat_path), 200)
            ->header('Content-Type', $disk->mimeType($lks->sertifikat_path));
    }

    public function downloadSertifikatProvinsiPublic($id)
    {
        $lks = LKS::findOrFail($id);
        $this->checkLksAccess($lks);

        if (!$lks->sertifikat_path || !Storage::disk('public')->exists($lks->sertifikat_path)) {
            abort(404, 'Tanda pendaftaran provinsi tidak ditemukan');
        }
        return Storage::disk('public')->download($lks->sertifikat_path);
    }
}
