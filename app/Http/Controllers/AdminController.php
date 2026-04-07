<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\LKS;
use App\Models\Admin;
use App\Services\GoogleSheetService;
use App\Models\HibahLks;
use App\Models\Checklist;
use App\Jobs\SyncLKSToGoogleSheets;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman admin index
     */
    public function adminIndex(Request $request)
    {
        $query = LKS::with('checklists');

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status_permohonan', $request->status);
        }

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lks', 'like', "%{$search}%")
                  ->orWhere('alamat_lks', 'like', "%{$search}%")
                  ->orWhere('nama_ketua_lks', 'like', "%{$search}%")
                  ->orWhere('kabupaten_kota', 'like', "%{$search}%");
            });
        }

        $lks = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $tahun = $request->get('tahun');
        $hibahQuery = HibahLks::query();
        if (!empty($tahun)) {
            $hibahQuery->where('tahun', $tahun);
        }
        $hibahItems = $hibahQuery->latest()->paginate(10);
        
        $stats = [
            'total' => LKS::count(),
            'menunggu' => LKS::where('status_permohonan', 'Menunggu')->count(),
            'diterima_proses' => LKS::where('status_permohonan', 'Diterima untuk proses')->count(),
            'diterima' => LKS::where('status_permohonan', 'Diterima')->count(),
            'ditolak' => LKS::where('status_permohonan', 'Ditolak')->count(),
            'dikembalikan' => LKS::where('status_permohonan', 'Dikembalikan')->count(),
            'terverifikasi' => LKS::where('status_permohonan', 'Terverifikasi')->count(),
            'with_sertifikat' => LKS::whereNotNull('sertifikat_path')->where('sertifikat_path', '!=', '')->count(),
        ];
        
        return view('admin.index', compact('lks', 'stats', 'hibahItems') + ['selectedYear' => $tahun]);
    }

    /**
     * Tampilkan halaman verifikasi
     */
    public function showVerification($id)
    {
        $lks = LKS::with('checklists.document')->findOrFail($id);
        return view('admin.verification', compact('lks'));
    }

    /**
     * Proses penyimpanan verifikasi dari form admin verification
     */
    public function verification(Request $request, $id)
    {
        $lks = LKS::with(['checklists.document'])->findOrFail($id);

        $validated = $request->validate([
            'status_permohonan' => 'required|in:Diterima untuk proses,Ditolak,Dikembalikan',
            'alasan_penolakan' => 'nullable|string|required_if:status_permohonan,Ditolak',
            'alasan_dikembalikan' => 'nullable|string|required_if:status_permohonan,Dikembalikan',
            'verifikator' => 'required|string|max:100',
            'nama_verifikator' => 'required|string|max:100',
            'tandatangan' => 'nullable|string|max:100',
            'sertifikat' => 'nullable|file|mimes:pdf|max:5120' // 5MB
        ]);

        // Handle upload sertifikat jika status "Diterima untuk proses"
        if ($request->status_permohonan === 'Diterima untuk proses') {
            if ($request->hasFile('sertifikat') && $request->file('sertifikat')->isValid()) {
                // Hapus sertifikat lama jika ada
                if ($lks->sertifikat_path && Storage::disk('public')->exists($lks->sertifikat_path)) {
                    Storage::disk('public')->delete($lks->sertifikat_path);
                }

                $file = $request->file('sertifikat');
                $fileName = 'sertifikat_' . $lks->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('sertifikat', $fileName, 'public');
                $lks->sertifikat_path = $filePath;
            }
        } else {
            // Jika status bukan "Diterima untuk proses", hapus sertifikat jika ada
            if ($lks->sertifikat_path && Storage::disk('public')->exists($lks->sertifikat_path)) {
                Storage::disk('public')->delete($lks->sertifikat_path);
            }
            $lks->sertifikat_path = null;
        }

        // Update field pada LKS
        $lks->status_permohonan = $validated['status_permohonan'];
        $lks->alasan_penolakan = $validated['alasan_penolakan'] ?? null;
        $lks->alasan_dikembalikan = $validated['alasan_dikembalikan'] ?? null;
        $lks->verifikator_id = $validated['verifikator'];
        $lks->nama_verifikator = $validated['nama_verifikator'];
        $lks->save();

        // Sync to Google Sheets if status is "Diterima untuk proses"
        if ($validated['status_permohonan'] === 'Diterima untuk proses') {
            SyncLKSToGoogleSheets::dispatch($lks);
        }

        // Simpan log verifikasi ke tabel admin - HANYA field yang ada di tabel
        $admin = new Admin();
        $admin->nama_verifikator = $validated['nama_verifikator'];
        $admin->verifikator = $validated['verifikator'];
        $admin->nomor_kontak = $lks->nomor_kontak;
        $admin->tandatangan = $validated['tandatangan'] ?? null;
        $admin->nama_lks = $lks->nama_lks;
        $admin->alamat_lks = $lks->alamat_lks;
        $admin->tanda_pendaftaran = $lks->tanda_pendaftaran;
        $admin->tanggal_masuk_dokumen = $lks->tanggal_masuk_dokumen;
        $admin->tanggal_persyaratan = $lks->tanggal_persyaratan;
        $admin->pendaftaran_lengkap = $lks->pendaftaran_lengkap;
        $admin->status_permohonan = $validated['status_permohonan'];
        $admin->alasan_penolakan = $validated['alasan_penolakan'] ?? null;
        $admin->alasan_dikembalikan = $validated['alasan_dikembalikan'] ?? null;
        $admin->sertifikat_path = $lks->sertifikat_path;
        $admin->save();

        return redirect()->route('admin.lks.index')
            ->with('success', 'Verifikasi berhasil disimpan.');
    }

    /**
     * Download sertifikat
     */
    public function downloadSertifikat($id): BinaryFileResponse
    {
        $lks = LKS::findOrFail($id);
        
        if (!$lks->sertifikat_path || !Storage::disk('public')->exists($lks->sertifikat_path)) {
            abort(404, 'Sertifikat tidak ditemukan');
        }

        $filePath = Storage::disk('public')->path($lks->sertifikat_path);
        $fileName = 'sertifikat_' . $lks->nama_lks . '.pdf';

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Preview sertifikat
     */
    public function previewSertifikat($id)
    {
        $lks = LKS::findOrFail($id);
        
        if (!$lks->sertifikat_path || !Storage::disk('public')->exists($lks->sertifikat_path)) {
            abort(404, 'Sertifikat tidak ditemukan');
        }

        $filePath = Storage::disk('public')->path($lks->sertifikat_path);
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="sertifikat_' . $lks->nama_lks . '.pdf"'
        ]);
    }

    /**
     * Hapus sertifikat
     */
    public function deleteSertifikat($id)
    {
        $lks = LKS::findOrFail($id);
        
        if ($lks->sertifikat_path && Storage::disk('public')->exists($lks->sertifikat_path)) {
            Storage::disk('public')->delete($lks->sertifikat_path);
            $lks->sertifikat_path = null;
            $lks->save();

            return redirect()->back()->with('success', 'Sertifikat berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Sertifikat tidak ditemukan.');
    }

    /**
     * Tampilkan halaman edit LKS
     */
    public function edit($id)
    {
        $lks = LKS::with('checklists.document')->findOrFail($id);
        return view('admin.edit', compact('lks'));
    }

    /**
     * Update data LKS
     */
    public function update(Request $request, $id)
    {
        $lks = LKS::findOrFail($id);

        $validated = $request->validate([
            'nama_lks' => 'required|string|max:255',
            'alamat_lks' => 'required|string',
            'nama_ketua_lks' => 'nullable|string|max:255',
            'jenis_pelayanan' => 'nullable|string|max:255',
            'jumlah_binaan_dalam_panti' => 'nullable|integer|min:0',
            'jumlah_binaan_luar_panti' => 'nullable|integer|min:0',
            'lokasi_lks' => 'nullable|string|max:255',
            'pusat_lks' => 'nullable|string|max:255',
            'cabang_lks' => 'nullable|string|max:255',
            'nomor_kontak' => 'nullable|string|max:20',
            'tanda_pendaftaran' => 'required|in:Baru,Ulang',
            'tanggal_masuk_dokumen' => 'required|date',
            'tanggal_persyaratan' => 'nullable|date',
            'pendaftaran_lengkap' => 'boolean',
            'kabupaten_kota' => 'nullable|string|max:255',
        ]);

        $lks->update($validated);

        return redirect()->route('admin.lks.index')
            ->with('success', 'Data LKS berhasil diperbarui.');
    }

    /**
     * Hapus data LKS
     */
    public function destroy($id)
    {
        $lks = LKS::findOrFail($id);

        // Hapus sertifikat jika ada
        if ($lks->sertifikat_path && Storage::disk('public')->exists($lks->sertifikat_path)) {
            Storage::disk('public')->delete($lks->sertifikat_path);
        }

        $lks->delete();

        return redirect()->route('admin.lks.index')
            ->with('success', 'Data LKS berhasil dihapus.');
    }

    /**
     * Tampilkan detail LKS
     */
    public function show($id)
    {
        $lks = LKS::with('checklists.document')->findOrFail($id);
        return view('admin.show', compact('lks'));
    }

    /**
     * Verifikasi dokumen LKS
     */
    public function verifyDocuments(Request $request, $id)
    {
        $lks = LKS::findOrFail($id);

        $request->validate([
            'verified_documents' => 'nullable|array',
            'verified_documents.*' => 'exists:checklists,id',
        ]);

        DB::transaction(function () use ($request, $lks) {
            // Reset semua verifikasi
            $lks->checklists()->update(['verified' => false]);

            // Set verifikasi untuk yang dipilih
            if ($request->has('verified_documents')) {
                Checklist::whereIn('id', $request->verified_documents)
                        ->update(['verified' => true]);
            }

            // Update status LKS jika semua dokumen wajib terverifikasi
            $allRequiredVerified = $lks->checklists()
                ->whereHas('document', function($query) {
                    $query->where('wajib', true);
                })
                ->where('verified', false)
                ->count() === 0;

            if ($allRequiredVerified) {
                $lks->update(['status_permohonan' => 'Terverifikasi']);
            }
        });

        return redirect()->route('admin.lks.index')
            ->with('success', 'Verifikasi dokumen berhasil disimpan.');
    }

    /**
     * Simpan hasil verifikasi admin ke database admin (legacy method)
     */
    public function storeVerification(Request $request)
    {
        $request->validate([
            'lks_id' => 'required|exists:lks,id',
            'status_permohonan' => 'required|in:Diterima untuk proses,Diterima,Ditolak,Dikembalikan',
            'alasan_penolakan' => 'nullable|string',
            'alasan_dikembalikan' => 'nullable|string',
            'verifikator' => 'required|string|max:100',
            'nama_verifikator' => 'required|string|max:100',
            'tandatangan' => 'nullable|string|max:100',
            'sertifikat' => 'nullable|file|mimes:pdf|max:5120' // 5MB
        ]);

        $lks = LKS::findOrFail($request->lks_id);

        // Handle upload sertifikat jika ada
        $sertifikatPath = null;
        if ($request->hasFile('sertifikat') && $request->file('sertifikat')->isValid()) {
            $file = $request->file('sertifikat');
            $fileName = 'sertifikat_' . $lks->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('sertifikat', $fileName, 'public');
            $sertifikatPath = $filePath;
            
            // Update LKS jika perlu
            $lks->sertifikat_path = $sertifikatPath;
            $lks->save();
        }

        // HANYA gunakan field yang ada di tabel admin
        $admin = new Admin();
        $admin->nama_verifikator = $request->nama_verifikator;
        $admin->verifikator = $request->verifikator;
        $admin->nomor_kontak = $lks->nomor_kontak;
        $admin->tandatangan = $request->tandatangan;
        $admin->nama_lks = $lks->nama_lks;
        $admin->alamat_lks = $lks->alamat_lks;
        $admin->tanda_pendaftaran = $lks->tanda_pendaftaran;
        $admin->tanggal_masuk_dokumen = $lks->tanggal_masuk_dokumen;
        $admin->tanggal_persyaratan = $lks->tanggal_persyaratan;
        $admin->pendaftaran_lengkap = $lks->pendaftaran_lengkap;
        $admin->status_permohonan = $request->status_permohonan;
        $admin->alasan_penolakan = $request->alasan_penolakan;
        $admin->alasan_dikembalikan = $request->alasan_dikembalikan;
        $admin->sertifikat_path = $sertifikatPath;
        $admin->save();

        return redirect()->route('admin.lks.index')->with('success', 'Verifikasi berhasil disimpan ke tabel admin!');
    }

    /**
     * Sync LKS data to Google Sheets
     */
    private function syncToGoogleSheets(LKS $lks)
    {
        try {
            $googleSheetService = new GoogleSheetService();
            
            // Prepare data for Google Sheets
            $data = [
                $lks->id,
                $lks->nama_lks,
                $lks->alamat_lks,
                $lks->nama_ketua_lks,
                $lks->jenis_pelayanan,
                $lks->jumlah_binaan_dalam_panti,
                $lks->jumlah_binaan_luar_panti,
                $lks->kabupaten_kota ?? $lks->lokasi_lks,
                $lks->pusat_lks,
                $lks->cabang_lks,
                $lks->nomor_kontak,
                $lks->tanda_pendaftaran,
                $lks->tanggal_masuk_dokumen?->format('Y-m-d'),
                $lks->tanggal_persyaratan?->format('Y-m-d'),
                $lks->pendaftaran_lengkap ? 'Ya' : 'Tidak',
                $lks->status_permohonan,
                $lks->nama_verifikator,
                $lks->verifikator_id,
                $lks->created_at?->format('Y-m-d H:i:s'),
                $lks->updated_at?->format('Y-m-d H:i:s'),
            ];

            // Append data to Google Sheets
            $googleSheetService->appendData($data, 'Sheet1!A:Z');
            
            Log::info("LKS data synced to Google Sheets successfully", [
                'lks_id' => $lks->id,
                'nama_lks' => $lks->nama_lks,
                'status' => $lks->status_permohonan
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to sync LKS data to Google Sheets", [
                'lks_id' => $lks->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Bulk action untuk LKS
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,change_status',
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'exists:lks,id',
        ]);

        $selectedIds = $request->selected_ids;

        switch ($request->action) {
            case 'delete':
                return $this->bulkDelete($selectedIds);
            case 'change_status':
                $request->validate([
                    'status' => 'required|in:Menunggu,Diterima untuk proses,Diterima,Ditolak,Dikembalikan,Terverifikasi'
                ]);
                return $this->bulkChangeStatus($selectedIds, $request->status);
            default:
                return redirect()->back()->with('error', 'Aksi tidak valid.');
        }
    }

    /**
     * Bulk delete LKS
     */
    private function bulkDelete($ids)
    {
        try {
            DB::transaction(function () use ($ids) {
                $lksList = LKS::whereIn('id', $ids)->get();
                
                foreach ($lksList as $lks) {
                    // Hapus sertifikat jika ada
                    if ($lks->sertifikat_path && Storage::disk('public')->exists($lks->sertifikat_path)) {
                        Storage::disk('public')->delete($lks->sertifikat_path);
                    }
                    $lks->delete();
                }
            });

            return redirect()->back()->with('success', count($ids) . ' data LKS berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Bulk delete error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Bulk change status LKS
     */
    private function bulkChangeStatus($ids, $status)
    {
        try {
            LKS::whereIn('id', $ids)->update(['status_permohonan' => $status]);

            // Jika status diubah ke selain "Diterima untuk proses", hapus sertifikat
            if ($status !== 'Diterima untuk proses') {
                $lksWithSertifikat = LKS::whereIn('id', $ids)
                    ->whereNotNull('sertifikat_path')
                    ->get();
                
                foreach ($lksWithSertifikat as $lks) {
                    if (Storage::disk('public')->exists($lks->sertifikat_path)) {
                        Storage::disk('public')->delete($lks->sertifikat_path);
                    }
                    $lks->sertifikat_path = null;
                    $lks->save();
                }
            }

            return redirect()->back()->with('success', count($ids) . ' data LKS berhasil diubah statusnya menjadi ' . $status . '.');
        } catch (\Exception $e) {
            Log::error('Bulk change status error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Export data LKS
     */
    public function export(Request $request)
    {
        $query = LKS::with('checklists');

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status_permohonan', $request->status);
        }

        $lks = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="data_lks_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($lks) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Header CSV
            fputcsv($file, [
                'ID', 'Nama LKS', 'Alamat', 'Nama Ketua', 'Jenis Pelayanan',
                'Binaan Dalam Panti', 'Binaan Luar Panti', 'Kabupaten/Kota',
                'Lokasi LKS', 'Pusat LKS', 'Cabang LKS', 'Nomor Kontak', 
                'Tanda Pendaftaran', 'Tanggal Masuk', 'Tanggal Persyaratan',
                'Status', 'Kelengkapan', 'Nama Verifikator', 'ID Verifikator',
                'Sertifikat', 'Dibuat Pada', 'Diupdate Pada'
            ]);

            // Data CSV
            foreach ($lks as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->nama_lks,
                    $item->alamat_lks,
                    $item->nama_ketua_lks ?? '-',
                    $item->jenis_pelayanan ?? '-',
                    $item->jumlah_binaan_dalam_panti ?? '0',
                    $item->jumlah_binaan_luar_panti ?? '0',
                    $item->kabupaten_kota ?? '-',
                    $item->lokasi_lks ?? '-',
                    $item->pusat_lks ?? '-',
                    $item->cabang_lks ?? '-',
                    $item->nomor_kontak ?? '-',
                    $item->tanda_pendaftaran,
                    $item->tanggal_masuk_dokumen?->format('d/m/Y') ?? '-',
                    $item->tanggal_persyaratan?->format('d/m/Y') ?? '-',
                    $item->status_permohonan,
                    $item->pendaftaran_lengkap ? 'Lengkap' : 'Tidak Lengkap',
                    $item->nama_verifikator ?? '-',
                    $item->verifikator_id ?? '-',
                    $item->sertifikat_path ? 'Ya' : 'Tidak',
                    $item->created_at?->format('d/m/Y H:i') ?? '-',
                    $item->updated_at?->format('d/m/Y H:i') ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data dengan filter
     */
    public function exportFiltered(Request $request)
    {
        $request->validate([
            'status' => 'nullable|string',
            'sertifikat' => 'nullable|in:ada,tidak'
        ]);

        $query = LKS::with('checklists');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_permohonan', $request->status);
        }

        // Filter berdasarkan sertifikat
        if ($request->has('sertifikat')) {
            if ($request->sertifikat === 'ada') {
                $query->whereNotNull('sertifikat_path')->where('sertifikat_path', '!=', '');
            } else {
                $query->whereNull('sertifikat_path')->orWhere('sertifikat_path', '');
            }
        }

        $lks = $query->orderBy('created_at', 'desc')->get();

        $filterInfo = [];
        if ($request->status) $filterInfo[] = 'Status: ' . $request->status;
        if ($request->sertifikat) $filterInfo[] = 'Sertifikat: ' . ($request->sertifikat === 'ada' ? 'Dengan Sertifikat' : 'Tanpa Sertifikat');

        $filename = 'data_lks_' . date('Y-m-d_H-i-s');
        if (!empty($filterInfo)) {
            $filename .= '_' . str_replace([' ', ':'], '_', implode('_', $filterInfo));
        }
        $filename .= '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($lks, $filterInfo) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Header dengan info filter
            if (!empty($filterInfo)) {
                fputcsv($file, ['Data LKS - ' . implode(', ', $filterInfo)]);
                fputcsv($file, []); // Empty row
            }

            // Header CSV
            fputcsv($file, [
                'ID', 'Nama LKS', 'Alamat', 'Nama Ketua', 'Jenis Pelayanan',
                'Binaan Dalam Panti', 'Binaan Luar Panti', 'Kabupaten/Kota',
                'Lokasi LKS', 'Pusat LKS', 'Cabang LKS', 'Nomor Kontak', 
                'Tanda Pendaftaran', 'Tanggal Masuk', 'Tanggal Persyaratan',
                'Status', 'Kelengkapan', 'Nama Verifikator', 'ID Verifikator',
                'Sertifikat', 'Dibuat Pada', 'Diupdate Pada'
            ]);

            // Data CSV
            foreach ($lks as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->nama_lks,
                    $item->alamat_lks,
                    $item->nama_ketua_lks ?? '-',
                    $item->jenis_pelayanan ?? '-',
                    $item->jumlah_binaan_dalam_panti ?? '0',
                    $item->jumlah_binaan_luar_panti ?? '0',
                    $item->kabupaten_kota ?? '-',
                    $item->lokasi_lks ?? '-',
                    $item->pusat_lks ?? '-',
                    $item->cabang_lks ?? '-',
                    $item->nomor_kontak ?? '-',
                    $item->tanda_pendaftaran,
                    $item->tanggal_masuk_dokumen?->format('d/m/Y') ?? '-',
                    $item->tanggal_persyaratan?->format('d/m/Y') ?? '-',
                    $item->status_permohonan,
                    $item->pendaftaran_lengkap ? 'Lengkap' : 'Tidak Lengkap',
                    $item->nama_verifikator ?? '-',
                    $item->verifikator_id ?? '-',
                    $item->sertifikat_path ? 'Ya' : 'Tidak',
                    $item->created_at?->format('d/m/Y H:i') ?? '-',
                    $item->updated_at?->format('d/m/Y H:i') ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get LKS statistics for API
     */
    public function getStatistics()
    {
        $stats = [
            'total' => LKS::count(),
            'menunggu' => LKS::where('status_permohonan', 'Menunggu')->count(),
            'diterima_proses' => LKS::where('status_permohonan', 'Diterima untuk proses')->count(),
            'diterima' => LKS::where('status_permohonan', 'Diterima')->count(),
            'ditolak' => LKS::where('status_permohonan', 'Ditolak')->count(),
            'dikembalikan' => LKS::where('status_permohonan', 'Dikembalikan')->count(),
            'terverifikasi' => LKS::where('status_permohonan', 'Terverifikasi')->count(),
            'with_sertifikat' => LKS::whereNotNull('sertifikat_path')->where('sertifikat_path', '!=', '')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * API untuk mendapatkan data LKS
     */
    public function apiIndex(Request $request)
    {
        $query = LKS::with('checklists');

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status_permohonan', $request->status);
        }

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lks', 'like', "%{$search}%")
                  ->orWhere('alamat_lks', 'like', "%{$search}%")
                  ->orWhere('nama_ketua_lks', 'like', "%{$search}%");
            });
        }

        $lks = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $lks,
            'message' => 'Data LKS berhasil diambil'
        ]);
    }

    /**
     * API untuk mendapatkan detail LKS
     */
    public function apiShow($id)
    {
        $lks = LKS::with('checklists.document')->find($id);
        
        if (!$lks) {
            return response()->json([
                'success' => false,
                'message' => 'Data LKS tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $lks,
            'message' => 'Detail LKS berhasil diambil'
        ]);
    }
}