<?php

namespace App\Http\Controllers;

use App\Models\HibahLks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class HibahLksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun = request('tahun', now()->year);
        $items = HibahLks::where('tahun', $tahun)->latest()->paginate(10)->appends(['tahun' => $tahun]);
        
        $statistics = $this->getStatistics($tahun);
        
        return view('hibah.index', [
            'items' => $items,
            'selectedYear' => $tahun,
            'totalProposal' => $statistics['totalProposal'],
            'proposalTerupload' => $statistics['proposalTerupload'],
            'lpjTerupload' => $statistics['lpjTerupload'],
            'dokumenLengkap' => $statistics['dokumenLengkap']
        ]);
    }

     public function documents($id)
    {
        $hibah = HibahLks::findOrFail($id);
        
        // Ambil semua data tahun untuk LKS ini
        $allYearsData = HibahLks::where('nama_lks', $hibah->nama_lks)
            ->orderBy('tahun', 'desc')
            ->get();
    
        // Ambil dokumen pendukung dari tahun mana saja (untuk referensi)
        $availableSupportingDocs = $this->getAvailableSupportingDocuments($hibah->nama_lks);
    
        // Cek apakah ada data untuk tahun sebelumnya
        $previousYearData = null;
        if ($hibah->tahun > 2023) {
            $previousYearData = HibahLks::where('nama_lks', $hibah->nama_lks)
                ->where('tahun', $hibah->tahun - 1)
                ->first();
        }
    
        return view('hibah.documents', compact('hibah', 'allYearsData', 'availableSupportingDocs', 'previousYearData'));
    }


    /**
     * Display admin documents management page
     */
    public function adminDocuments($id)
    {
        $this->authorizeAdmin();
        return $this->documents($id);
    }
    /**
     * Get available supporting documents from any year
     */
    private function getAvailableSupportingDocuments($nama_lks)
    {
        return HibahLks::where('nama_lks', $nama_lks)
            ->where(function($query) {
                $query->whereNotNull('hasil_verifikasi_path')
                    ->orWhereNotNull('pergub_penjabaran_apbd_path')
                    ->orWhereNotNull('dpa_path')
                    ->orWhereNotNull('hasil_identifikasi_path')
                    ->orWhereNotNull('data_penerima_hibah_path')
                    ->orWhereNotNull('spm_path')
                    ->orWhereNotNull('sp2d_path')
                    ->orWhereNotNull('petunjuk_teknis_path')
                    ->orWhereNotNull('surat_ket_lampiran_verifikasi_path')
                    ->orWhereNotNull('bukti_pembayaran_transfer_path')
                    ->orWhereNotNull('sk_kadinsos_tim_verifikasi_path');
            })
            ->orderBy('tahun', 'desc')
            ->get();
    }

    /**
     * Get documents content via AJAX
     */
    public function getDocumentsContent($id)
    {
        $hibah = HibahLks::findOrFail($id);
        return view('hibah.partials.documents-content', compact('hibah'))->render();
    }


    /**
     * Display keuangan data for specific year
     */
    public function keuangan($tahun)
    {
        $items = HibahLks::where('tahun', $tahun)->latest()->paginate(10)->appends(['tahun' => $tahun]);
        $statistics = $this->getStatistics($tahun);
        
        return view('hibah.index', [
            'items' => $items,
            'selectedYear' => $tahun,
            'totalProposal' => $statistics['totalProposal'],
            'proposalTerupload' => $statistics['proposalTerupload'],
            'lpjTerupload' => $statistics['lpjTerupload'],
            'dokumenLengkap' => $statistics['dokumenLengkap']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hibah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lks' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2023|max:2100',
            'proposal' => 'nullable|file|max:51200',
            'lpj'      => 'nullable|file|max:51200',
        ]);

        $data = [
            'nama_lks' => $validated['nama_lks'],
            'tahun' => $validated['tahun'],
        ];

        // Simpan proposal
        if ($request->hasFile('proposal')) {
            $data['proposal_path'] = $request->file('proposal')->store('hibah', 'public');
        }

        // Simpan LPJ (semua role bisa upload)
        if ($request->hasFile('lpj')) {
            $data['lpj_path'] = $request->file('lpj')->store('hibah', 'public');
        }

        // Semua dokumen pendukung berlaku per-tahun (update semua LKS dalam tahun yang sama)
        if (Auth::user() && in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            $adminMap = [
                'hasil_verifikasi'              => 'hasil_verifikasi_path',
                'pergub_penjabaran_apbd'        => 'pergub_penjabaran_apbd_path',
                'dpa'                           => 'dpa_path',
                'hasil_identifikasi'            => 'hasil_identifikasi_path',
                'data_penerima_hibah'           => 'data_penerima_hibah_path',
                'spm'                           => 'spm_path',
                'sp2d'                          => 'sp2d_path',
                'petunjuk_teknis'               => 'petunjuk_teknis_path',
                'surat_ket_lampiran_verifikasi' => 'surat_ket_lampiran_verifikasi_path',
                'bukti_pembayaran_transfer'     => 'bukti_pembayaran_transfer_path',
                'sk_kadinsos_tim_verifikasi'    => 'sk_kadinsos_tim_verifikasi_path',
            ];
            foreach ($adminMap as $input => $column) {
                if ($request->hasFile($input)) {
                    $data[$column] = $request->file($input)->store('hibah', 'public');
                    HibahLks::where('tahun', $validated['tahun'])
                        ->update([$column => $data[$column]]);
                }
            }
        }

        $item = HibahLks::create($data);
        return redirect()->route('hibah.index', ['tahun' => $validated['tahun']])
            ->with('success', 'Data hibah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hibah = HibahLks::findOrFail($id);
        return view('hibah.show', compact('hibah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hibah = HibahLks::findOrFail($id);
        return view('hibah.edit', compact('hibah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hibah = HibahLks::findOrFail($id);
        
        $validated = $request->validate([
            'nama_lks' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2023|max:2100',
            'proposal' => 'nullable|file|max:51200',
            'lpj'      => 'nullable|file|max:51200',
        ]);

        $hibah->nama_lks = $validated['nama_lks'];
        $hibah->tahun = $validated['tahun'];

        if ($request->hasFile('proposal')) {
            if ($hibah->proposal_path) {
                Storage::disk('public')->delete($hibah->proposal_path);
            }
            $hibah->proposal_path = $request->file('proposal')->store('hibah', 'public');
        }

        // LPJ bisa diupload semua role
        if ($request->hasFile('lpj')) {
            if ($hibah->lpj_path) {
                Storage::disk('public')->delete($hibah->lpj_path);
            }
            $hibah->lpj_path = $request->file('lpj')->store('hibah', 'public');
        }

        if (Auth::user() && in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            // Semua dokumen pendukung berlaku per-tahun
            $adminMap = [
                'hasil_verifikasi'              => 'hasil_verifikasi_path',
                'pergub_penjabaran_apbd'        => 'pergub_penjabaran_apbd_path',
                'dpa'                           => 'dpa_path',
                'hasil_identifikasi'            => 'hasil_identifikasi_path',
                'data_penerima_hibah'           => 'data_penerima_hibah_path',
                'spm'                           => 'spm_path',
                'sp2d'                          => 'sp2d_path',
                'petunjuk_teknis'               => 'petunjuk_teknis_path',
                'surat_ket_lampiran_verifikasi' => 'surat_ket_lampiran_verifikasi_path',
                'bukti_pembayaran_transfer'     => 'bukti_pembayaran_transfer_path',
                'sk_kadinsos_tim_verifikasi'    => 'sk_kadinsos_tim_verifikasi_path',
            ];
            foreach ($adminMap as $input => $column) {
                if ($request->hasFile($input)) {
                    if ($hibah->$column) {
                        Storage::disk('public')->delete($hibah->$column);
                    }
                    $newPath = $request->file($input)->store('hibah', 'public');
                    $hibah->$column = $newPath;
                    HibahLks::where('tahun', $hibah->tahun)
                        ->update([$column => $newPath]);
                }
            }
        }

        $hibah->save();
        return redirect()->route('hibah.index', ['tahun' => $validated['tahun']])
            ->with('success', 'Data hibah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hibah = HibahLks::findOrFail($id);

        
        $map = [
            'proposal_path',
            'hasil_verifikasi_path',
            'pergub_penjabaran_apbd_path',
            'dpa_path',
            'hasil_identifikasi_path',
            'data_penerima_hibah_path',
            'spm_path',
            'sp2d_path',
            'lpj_path',
            'petunjuk_teknis_path',
            'surat_ket_lampiran_verifikasi_path',
            'bukti_pembayaran_transfer_path',
            'sk_kadinsos_tim_verifikasi_path',
        ];
        foreach ($map as $column) {
            if ($hibah->$column) {
                Storage::disk('public')->delete($hibah->$column);
            }
        }
        $hibah->delete();
        return redirect()->route('hibah.index')
        ->with('success', 'Data hibah berhasil dihapus');
    }

    public function sContent($id)
    {
        $hibah = HibahLks::findOrFail($id);
        return view('hibah.partials.documents-content', compact('hibah'))->render();
    }

    /**
     * Upload dokumen pendukung via form biasa - untuk semua LKS dalam tahun
     */
    public function uploadDocument(Request $request, $id)
    {
        $hibah = HibahLks::findOrFail($id);
        $tahun = $hibah->tahun;

        $request->validate([
            'document_type' => 'required|string',
            'document_file' => 'required|file|max:51200'
        ]);

        $documentType = $request->document_type;
        $fileField = $documentType . '_path';

        // Validasi field yang diizinkan
        $allowedFields = [
            'proposal',
            'lpj',
            'hasil_verifikasi',
            'pergub_penjabaran_apbd',
            'dpa',
            'hasil_identifikasi',
            'data_penerima_hibah',
            'spm',
            'sp2d',
            'petunjuk_teknis',
            'surat_ket_lampiran_verifikasi',
            'bukti_pembayaran_transfer',
            'sk_kadinsos_tim_verifikasi',
        ];

        if (!in_array($documentType, $allowedFields)) {
            return redirect()->back()->with('error', 'Jenis dokumen tidak valid');
        }

        try {
            // Untuk proposal dan lpj: update hanya record ini (per-LKS)
            // Untuk dokumen pendukung lainnya: update semua LKS dalam tahun yang sama
            $isPerLks = in_array($documentType, ['proposal', 'lpj']);

            if ($isPerLks) {
                // Hapus file lama jika ada
                if ($hibah->$fileField && Storage::disk('public')->exists($hibah->$fileField)) {
                    Storage::disk('public')->delete($hibah->$fileField);
                }

                // Upload file baru
                $file = $request->file('document_file');
                $fileName = $this->generateBulkFileName($documentType, $tahun, $file);
                $filePath = $file->storeAs('hibah', $fileName, 'public');

                // Update hanya record ini
                $hibah->update([$fileField => $filePath]);

                return redirect()->route('hibah.documents', $hibah->id)
                    ->with('success', "Dokumen {$documentType} berhasil diupload!");
            }

            // Hapus file lama jika ada (untuk semua LKS di tahun ini)
            $this->deleteOldBulkFiles($tahun, $fileField);

            // Upload file baru
            $file = $request->file('document_file');
            $fileName = $this->generateBulkFileName($documentType, $tahun, $file);
            $filePath = $file->storeAs('hibah', $fileName, 'public');

            // Update semua LKS dengan tahun yang sama
            $updatedCount = HibahLks::where('tahun', $tahun)
                ->update([$fileField => $filePath]);

            return redirect()->route('hibah.documents', $hibah->id)
                ->with('success', "Dokumen {$documentType} berhasil diupload untuk {$updatedCount} LKS tahun {$tahun}!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupload dokumen: ' . $e->getMessage());
        }
    }

     /**
     * Hapus dokumen pendukung - untuk semua LKS dalam tahun
     */
    public function deleteDocument(Request $request, $id)
    {
        $hibah = HibahLks::findOrFail($id);
        $tahun = $hibah->tahun;

        $request->validate([
            'document_type' => 'required|string'
        ]);

        $documentType = $request->document_type;
        $fileField = $documentType . '_path';

        // Validasi field yang diizinkan
        $allowedFields = [
            'proposal',
            'lpj',
            'hasil_verifikasi',
            'pergub_penjabaran_apbd',
            'dpa',
            'hasil_identifikasi',
            'data_penerima_hibah',
            'spm',
            'sp2d',
            'petunjuk_teknis',
            'surat_ket_lampiran_verifikasi',
            'bukti_pembayaran_transfer',
            'sk_kadinsos_tim_verifikasi',
        ];

        if (!in_array($documentType, $allowedFields)) {
            return redirect()->back()->with('error', 'Jenis dokumen tidak valid');
        }

        try {
            // Hapus file dari storage (untuk semua LKS di tahun ini)
            $existingRecord = HibahLks::where('tahun', $tahun)
                ->whereNotNull($fileField)
                ->first();

            if ($existingRecord && $existingRecord->$fileField && Storage::disk('public')->exists($existingRecord->$fileField)) {
                Storage::disk('public')->delete($existingRecord->$fileField);
            }

            // Update semua LKS dengan tahun yang sama
            $updatedCount = HibahLks::where('tahun', $tahun)
                ->update([$fileField => null]);

            return redirect()->route('hibah.documents', $hibah->id)
                ->with('success', "Dokumen {$documentType} berhasil dihapus dari {$updatedCount} LKS tahun {$tahun}!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Bulk upload supporting documents - FIXED VERSION
     */
    public function bulkUploadSupportingDocuments(Request $request, $id)
    {
        $this->authorizeAdmin();
        $hibah = HibahLks::findOrFail($id);
    
        // Validasi yang lebih fleksibel
        $request->validate([
            'supporting_documents' => 'sometimes|array',
            'supporting_documents.*' => 'sometimes|file|max:51200'
        ]);
    
        try {
            // Semua dokumen pendukung berlaku per-tahun
            $documentMap = [
                'hasil_verifikasi'              => 'hasil_verifikasi_path',
                'pergub_penjabaran_apbd'        => 'pergub_penjabaran_apbd_path',
                'dpa'                           => 'dpa_path',
                'hasil_identifikasi'            => 'hasil_identifikasi_path',
                'data_penerima_hibah'           => 'data_penerima_hibah_path',
                'spm'                           => 'spm_path',
                'sp2d'                          => 'sp2d_path',
                'petunjuk_teknis'               => 'petunjuk_teknis_path',
                'surat_ket_lampiran_verifikasi' => 'surat_ket_lampiran_verifikasi_path',
                'bukti_pembayaran_transfer'     => 'bukti_pembayaran_transfer_path',
                'sk_kadinsos_tim_verifikasi'    => 'sk_kadinsos_tim_verifikasi_path',
            ];

            $uploadedCount = 0;

            foreach ($documentMap as $docType => $field) {
                if ($request->hasFile("supporting_documents.{$docType}")) {
                    $file = $request->file("supporting_documents.{$docType}");
                    if ($file && $file->isValid()) {
                        // Hapus file lama untuk tahun ini
                        $existingRecord = HibahLks::where('tahun', $hibah->tahun)
                            ->whereNotNull($field)->first();
                        if ($existingRecord && $existingRecord->$field && Storage::disk('public')->exists($existingRecord->$field)) {
                            Storage::disk('public')->delete($existingRecord->$field);
                        }

                        $fileName = $this->generateBulkFileName($docType, $hibah->tahun, $file);
                        $filePath = $file->storeAs('hibah', $fileName, 'public');

                        // Update semua LKS dalam tahun yang sama
                        HibahLks::where('tahun', $hibah->tahun)
                            ->update([$field => $filePath]);

                        $uploadedCount++;
                    }
                }
            }
        
            if ($uploadedCount > 0) {
                return redirect()->route('hibah.documents', $hibah->id)
                    ->with('success', $uploadedCount . ' dokumen pendukung berhasil diupload!');
            } else {
                return redirect()->back()->with('warning', 'Tidak ada dokumen yang dipilih untuk diupload.');
            }
        
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Generate nama file untuk bulk upload
     */
    private function generateBulkFileName($documentType, $tahun, $file)
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = time();
        $safeDocType = preg_replace('/[^a-zA-Z0-9]/', '_', $documentType);

        return "{$safeDocType}_tahun{$tahun}_bulk_{$timestamp}.{$extension}";
    }

    /**
     * Hapus file lama untuk bulk upload
     */
    private function deleteOldBulkFiles($tahun, $field)
    {
        try {
            // Ambil path file yang akan diganti
            $existingRecord = HibahLks::where('tahun', $tahun)
                ->whereNotNull($field)
                ->first();

            if ($existingRecord && $existingRecord->$field) {
                $oldFilePath = $existingRecord->$field;

                // Hapus file dari storage jika ada
                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            }
        } catch (\Exception $e) {
            \Log::error("Gagal menghapus file lama: " . $e->getMessage());
        }
    }

    /**
     * Preview document - Lihat dokumen di browser
     */
    public function previewDocument($id, $document_type)
    {
        $hibah = HibahLks::findOrFail($id);
        $fileField = $document_type . '_path';
        
        if (!$hibah->$fileField) {
            abort(404, 'Dokumen tidak ditemukan');
        }
        
        $filePath = $hibah->$fileField;
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan di storage');
        }
        
        $file = Storage::disk('public')->get($filePath);
        $mimeType = Storage::disk('public')->mimeType($filePath);
        
        return Response::make($file, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    /**
     * Download document - Unduh dokumen
     */
    public function downloadDocument($id, $document_type)
    {
        $hibah = HibahLks::findOrFail($id);
        $fileField = $document_type . '_path';
        
        if (!$hibah->$fileField) {
            abort(404, 'Dokumen tidak ditemukan');
        }
        
        $filePath = $hibah->$fileField;
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan di storage');
        }
        
        return Storage::disk('public')->download($filePath, 
            $document_type . '_' . $hibah->nama_lks . '.pdf');
    }

    /**
     * View document - Alternatif untuk melihat dokumen
     */
    public function viewDocument($id, $document_type)
    {
        $hibah = HibahLks::findOrFail($id);
        $fileField = $document_type . '_path';
        
        if (!$hibah->$fileField) {
            abort(404, 'Dokumen tidak ditemukan');
        }
        
        $filePath = $hibah->$filePath;
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan di storage');
        }
        
        // Redirect ke URL file di storage
        return redirect(Storage::disk('public')->url($filePath));
    }

    /**
     * Update status verifikasi (untuk admin)
     */
    public function updateStatusVerifikasi(Request $request, $id)
    {
        $this->authorizeAdmin();

        $hibah = HibahLks::findOrFail($id);

        $request->validate([
            'status_verifikasi' => 'required|in:diverifikasi,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:1000'
        ]);

        try {
            $hibah->update([
                'status_verifikasi' => $request->status_verifikasi,
                'catatan_verifikasi' => $request->catatan_verifikasi
            ]);

            $statusText = $request->status_verifikasi == 'diverifikasi' ? 'diverifikasi' : 'ditolak';

            return redirect()->back()->with('success', 'Status verifikasi berhasil diupdate menjadi ' . $statusText . '!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate status verifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics including verification data
     */
    private function getStatisticsWithVerification($tahun)
    {
        $totalProposal = HibahLks::where('tahun', $tahun)->count();
        $proposalTerupload = HibahLks::where('tahun', $tahun)->whereNotNull('proposal_path')->count();
        $lpjTerupload = HibahLks::where('tahun', $tahun)->whereNotNull('lpj_path')->count();

        // Hitung dokumen lengkap (memiliki proposal dan LPJ)
        $dokumenLengkap = HibahLks::where('tahun', $tahun)
            ->whereNotNull('proposal_path')
            ->whereNotNull('lpj_path')
            ->count();

        // Statistik verifikasi
        $verifikasiAktif = HibahLks::where('tahun', $tahun)
            ->withVerifikasiAktif()
            ->count();

        $verifikasiDiterima = HibahLks::where('tahun', $tahun)
            ->where('status_verifikasi', 'diverifikasi')
            ->where('tahun_dokumen_verifikasi', now()->year)
            ->count();

        $perluUploadUlang = HibahLks::where('tahun', $tahun)
            ->perluUploadUlang()
            ->count();

        return [
            'totalProposal' => $totalProposal,
            'proposalTerupload' => $proposalTerupload,
            'lpjTerupload' => $lpjTerupload,
            'dokumenLengkap' => $dokumenLengkap,
            'verifikasiAktif' => $verifikasiAktif,
            'verifikasiDiterima' => $verifikasiDiterima,
            'perluUploadUlang' => $perluUploadUlang
        ];
    }

    /**
     * API Statistics
     */
    public function getStatisticsAPI($tahun)
    {
        $statistics = $this->getStatistics($tahun);
        return response()->json($statistics);
    }

    /**
     * API Hibah Data
     */
    public function getHibahData($tahun)
    {
        $items = HibahLks::where('tahun', $tahun)->get();
        return response()->json($items);
    }

    /**
     * Export Hibah Data
     */
    public function exportHibahData($tahun)
    {
        $items = HibahLks::where('tahun', $tahun)->get();
        
        // Your export logic here (CSV, Excel, etc.)
        // Contoh sederhana: return CSV
        $fileName = 'hibah-data-' . $tahun . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($items) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama LKS', 'Tahun', 'Proposal', 'LPJ']);

            foreach ($items as $item) {
                fputcsv($file, [
                    $item->nama_lks,
                    $item->tahun,
                    $item->proposal_path ? 'Ada' : 'Tidak Ada',
                    $item->lpj_path ? 'Ada' : 'Tidak Ada'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Store admin documents
     */
    public function adminDocumentsStore(Request $request, $id)
    {
        $this->authorizeAdmin();
        $hibah = HibahLks::findOrFail($id);
        
        // Your store logic here
        return redirect()->back()->with('success', 'Dokumen admin berhasil disimpan');
    }

    /**
     * Admin bulk upload
     */
    public function adminBulkUpload(Request $request, $id)
    {
        $this->authorizeAdmin();
        $hibah = HibahLks::findOrFail($id);
        
        // Your bulk upload logic here
        return redirect()->back()->with('success', 'Bulk upload berhasil');
    }

    /**
     * Admin bulk delete
     */
    public function adminBulkDelete(Request $request, $id)
    {
        $this->authorizeAdmin();
        $hibah = HibahLks::findOrFail($id);
        
        // Your bulk delete logic here
        return redirect()->back()->with('success', 'Bulk delete berhasil');
    }

    /**
     * Admin export
     */
    public function adminExport($tahun)
    {
        $this->authorizeAdmin();
        
        // Your export logic here
        $items = HibahLks::where('tahun', $tahun)->get();
        
        // Return export file
        return $this->exportHibahData($tahun); // Reuse export method
    }

    /**
     * Admin statistics
     */
    public function admintatistics($tahun)
    {
        $this->authorizeAdmin();
        
        $statistics = $this->getStatistics($tahun);
        
        return response()->json($statistics);
    }

    /**
     * Statistik untuk dashboard - TANPA KOLOM STATUS
     */
    private function getStatistics($tahun)
    {
        $totalProposal = HibahLks::where('tahun', $tahun)->count();
        $proposalTerupload = HibahLks::where('tahun', $tahun)->whereNotNull('proposal_path')->count();
        $lpjTerupload = HibahLks::where('tahun', $tahun)->whereNotNull('lpj_path')->count();
        
        // Hitung dokumen lengkap (memiliki proposal dan LPJ)
        $dokumenLengkap = HibahLks::where('tahun', $tahun)
            ->whereNotNull('proposal_path')
            ->whereNotNull('lpj_path')
            ->count();

        return [
            'totalProposal' => $totalProposal,
            'proposalTerupload' => $proposalTerupload,
            'lpjTerupload' => $lpjTerupload,
            'dokumenLengkap' => $dokumenLengkap
        ];
    }

    /**
     * Authorization for admin only
     */
    private function authorizeAdmin(): void
    {
        if (!(Auth::user() && in_array(Auth::user()->role, ['admin', 'super_admin']))) {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Generate unique filename untuk dokumen
     */
    private function generateFileName($hibah, $documentType, $file)
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = time();
        $safeLksName = preg_replace('/[^a-zA-Z0-9]/', '_', $hibah->nama_lks);
        
        return "{$documentType}_{$safeLksName}_shared_{$timestamp}.{$extension}";
    }

    

}