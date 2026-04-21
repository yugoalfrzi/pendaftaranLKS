<?php

namespace App\Http\Controllers;

use App\Models\lks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of LKS for admin panel
     */
    public function adminIndex(Request $request)
    {
        $query = lks::with('user');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_permohonan', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lks', 'like', "%{$search}%")
                  ->orWhere('alamat_lks', 'like', "%{$search}%");
            });
        }

        $lks = $query->latest()->paginate(15);

        // Statistics
        $stats = [
            'total' => lks::count(),
            'menunggu' => lks::where('status_permohonan', 'Menunggu')->count(),
            'diterima_proses' => lks::where('status_permohonan', 'Diterima untuk proses')->count(),
            'diterima' => lks::where('status_permohonan', 'Diterima')->count(),
            'terverifikasi' => lks::where('status_permohonan', 'Terverifikasi')->count(),
            'ditolak' => lks::where('status_permohonan', 'Ditolak')->count(),
            'dikembalikan' => lks::where('status_permohonan', 'Dikembalikan')->count(),
            'with_sertifikat' => lks::whereNotNull('surat_rekomendasi_path')->count(), // surat rekomendasi yang sudah diupload admin
        ];
        
        return view('admin.index', compact('lks', 'stats'));
    }

    /**
     * Show verification form
     */
    public function showVerification($id)
    {
        $lks = lks::with(['checklists.document', 'user'])->findOrFail($id);
        
        return view('admin.verification', compact('lks'));
    }

    /**
     * Process verification and upload surat rekomendasi
     */
    public function verification(Request $request, $id)
    {
        $lks = lks::findOrFail($id);

        $request->validate([
            'status_permohonan' => 'required|in:Diterima,Ditolak,Dikembalikan',
            'alasan_penolakan' => 'required_if:status_permohonan,Ditolak',
            'alasan_dikembalikan' => 'required_if:status_permohonan,Dikembalikan',
            'surat_rekomendasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Handle surat rekomendasi upload
        if ($request->hasFile('surat_rekomendasi')) {
            // Delete old file if exists
            if ($lks->surat_rekomendasi_path) {
                Storage::disk('public')->delete($lks->surat_rekomendasi_path);
            }

            $file = $request->file('surat_rekomendasi');
            $filename = 'surat_rekomendasi_' . $lks->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('surat_rekomendasi', $filename, 'public');
            
            $lks->surat_rekomendasi_path = $path;
        }

        $lks->status_permohonan = $request->status_permohonan;
        $lks->alasan_penolakan = $request->alasan_penolakan;
        $lks->alasan_dikembalikan = $request->alasan_dikembalikan;
        $lks->nama_verifikator = auth()->user()?->name ?? 'Unknown';
        $lks->save();

        return redirect()->route('admin.lks.index')
            ->with('success', 'Verifikasi berhasil diproses');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $lks = lks::with('user')->findOrFail($id);
        
        return view('admin.edit', compact('lks'));
    }

    /**
     * Update LKS data
     */
    public function update(Request $request, $id)
    {
        $lks = lks::findOrFail($id);

        $request->validate([
            'nama_lks' => 'required|string|max:255',
            'alamat_lks' => 'required|string',
            'status_permohonan' => 'required',
        ]);

        $lks->update($request->only([
            'nama_lks',
            'alamat_lks',
            'nomor_kontak',
            'kabupaten_kota',
            'lokasi_lks',
            'status_permohonan',
        ]));

        return redirect()->route('admin.lks.index')
            ->with('success', 'Data LKS berhasil diperbarui');
    }

    /**
     * Show LKS detail
     */
    public function show($id)
    {
        $lks = lks::with(['checklists.document', 'user'])->findOrFail($id);
        
        return view('lks.show', compact('lks'));
    }

    /**
     * Delete LKS
     */
    public function destroy($id)
    {
        $lks = lks::findOrFail($id);
        
        // Delete sertifikat if exists
        if ($lks->sertifikat_path) {
            Storage::disk('public')->delete($lks->sertifikat_path);
        }
        
        $lks->delete();

        return redirect()->route('admin.lks.index')
            ->with('success', 'Data LKS berhasil dihapus');
    }

    /**
     * Download surat rekomendasi
     */
    public function downloadSertifikat($id)
    {
        $lks = lks::findOrFail($id);

        if (!$lks->surat_rekomendasi_path || !Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            abort(404, 'Surat rekomendasi tidak ditemukan');
        }

        /** @var \Illuminate\Contracts\Filesystem\Filesystem $disk */
        $disk = Storage::disk('public');
        return $disk->download($lks->surat_rekomendasi_path);
    }

    /**
     * Preview surat rekomendasi
     */
    public function previewSertifikat($id)
    {
        $lks = lks::findOrFail($id);

        if (!$lks->surat_rekomendasi_path || !Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            abort(404, 'Surat rekomendasi tidak ditemukan');
        }

        /** @var \Illuminate\Contracts\Filesystem\Filesystem $disk */
        $disk = Storage::disk('public');
        $file = $disk->get($lks->surat_rekomendasi_path);
        $mimeType = $disk->mimeType($lks->surat_rekomendasi_path);

        return response($file, 200)->header('Content-Type', $mimeType);
    }

    /**
     * Delete surat rekomendasi
     */
    public function deleteSertifikat($id)
    {
        $lks = lks::findOrFail($id);

        if ($lks->surat_rekomendasi_path && Storage::disk('public')->exists($lks->surat_rekomendasi_path)) {
            Storage::disk('public')->delete($lks->surat_rekomendasi_path);
            $lks->surat_rekomendasi_path = null;
            $lks->save();
        }

        return redirect()->back()->with('success', 'Surat rekomendasi berhasil dihapus');
    }

    /**
     * Verify documents
     */
    public function verifyDocuments(Request $request, $id)
    {
        $lks = lks::findOrFail($id);
        
        // Update pendaftaran_lengkap status
        $lks->updatePendaftaranLengkap();

        return redirect()->back()->with('success', 'Status kelengkapan dokumen berhasil diperbarui');
    }

    /**
     * Bulk action
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,update_status',
            'ids' => 'required|array',
            'status' => 'required_if:action,update_status',
        ]);

        $ids = $request->ids;

        if ($request->action === 'delete') {
            lks::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        }

        if ($request->action === 'update_status') {
            lks::whereIn('id', $ids)->update(['status_permohonan' => $request->status]);
            return redirect()->back()->with('success', 'Status berhasil diperbarui');
        }

        return redirect()->back();
    }
}
