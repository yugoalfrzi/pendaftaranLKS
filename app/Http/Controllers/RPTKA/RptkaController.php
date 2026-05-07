<?php

namespace App\Http\Controllers\RPTKA;

use App\Http\Controllers\Controller;
use App\Models\rptka;
use App\Models\rptkaDocumentStatus;
use App\Models\MasterDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RptkaController extends Controller
{
    // ===================== USER =====================

    public function index(Request $request)
    {
        $query = rptka::query();

        // User hanya lihat miliknya sendiri
        if (auth()->user()->role === 'user') {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lks', 'like', "%{$search}%")
                  ->orWhere('nama_tka_pemohon', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('permohonan_rptka', $request->jenis);
        }

        if ($request->filled('status')) {
            $query->where('status_permohonan', $request->status);
        }

        $rptkas = $query->latest()->paginate(15);

        $baseQuery = auth()->user()->role === 'user'
            ? rptka::where('user_id', auth()->id())
            : rptka::query();

        $stats = [
            'total'        => (clone $baseQuery)->count(),
            'menunggu'     => (clone $baseQuery)->where('status_permohonan', 'Menunggu')->count(),
            'diterima'     => (clone $baseQuery)->where('status_permohonan', 'Diterima')->count(),
            'terverifikasi'=> (clone $baseQuery)->where('status_permohonan', 'Terverifikasi')->count(),
            'ditolak'      => (clone $baseQuery)->where('status_permohonan', 'Ditolak')->count(),
        ];

        return view('RPTKA.index', compact('rptkas', 'stats'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'user') {
            return redirect()->route('rptka.index')
                ->with('error', 'Hanya user yang dapat mendaftar RPTKA.');
        }
        return view('RPTKA.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'user') {
            return redirect()->route('rptka.index')
                ->with('error', 'Hanya user yang dapat mendaftar RPTKA.');
        }
        $request->validate([
            'nama_lks'               => 'required|string|max:200',
            'nama_tka_pemohon'       => 'required|string|max:200',
            'alamat_lks'             => 'required|string',
            'permohonan_rptka'       => 'required|in:Baru,Ulang',
            'tanggal_masuk_dokumen'  => 'required|date',
            'documents.*.keterangan' => 'nullable|string',
            'documents.*.file'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $rptka = rptka::create([
                'user_id'               => auth()->id(),
                'nama_lks'              => $request->nama_lks,
                'nama_tka_pemohon'      => $request->nama_tka_pemohon,
                'alamat_lks'            => $request->alamat_lks,
                'kabupaten_kota'        => auth()->user()->kabupaten_kota,
                'permohonan_rptka'      => $request->permohonan_rptka,
                'tanggal_masuk_dokumen' => $request->tanggal_masuk_dokumen,
                'status_permohonan'     => 'Menunggu',
            ]);

            $rptka->initializeDocumentStatuses();

            if ($request->has('documents')) {
                foreach ($request->documents as $docId => $docData) {
                    $filePath = null;
                    if (isset($docData['file']) && $docData['file']->isValid()) {
                        $file     = $docData['file'];
                        $filename = 'rptka_' . $rptka->id . '_' . $docId . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('rptka_documents', $filename, 'public');
                    }
                    rptkaDocumentStatus::updateOrCreate(
                        ['rptka_id' => $rptka->id, 'master_document_id' => $docId],
                        [
                            'is_ada'     => isset($docData['is_ada']) ? true : false,
                            'keterangan' => $docData['keterangan'] ?? null,
                            'file_path'  => $filePath,
                        ]
                    );
                }
            }

            $rptka->updateCompletionDate();
            DB::commit();

            return redirect()->route('rptka.show', $rptka->id)
                ->with('success', 'Permohonan RPTKA berhasil didaftarkan dan menunggu verifikasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $rptka = rptka::with(['documentStatuses.masterDocument'])->findOrFail($id);
        return view('RPTKA.show', compact('rptka'));
    }

    public function edit($id)
    {
        $rptka = rptka::with(['documentStatuses.masterDocument'])->findOrFail($id);

        // User hanya bisa edit miliknya sendiri dan status Menunggu/Dikembalikan
        if (auth()->user()->role === 'user') {
            if ($rptka->user_id !== auth()->id()) abort(403);
            if (!in_array($rptka->status_permohonan, ['Menunggu', 'Dikembalikan'])) {
                return redirect()->route('rptka.show', $id)
                    ->with('error', 'Permohonan tidak dapat diedit pada status ini.');
            }
        }

        return view('RPTKA.edit', compact('rptka'));
    }

    public function update(Request $request, $id)
    {
        $rptka = rptka::findOrFail($id);

        if (auth()->user()->role === 'user') {
            if ($rptka->user_id !== auth()->id()) abort(403);
        }

        $request->validate([
            'nama_lks'               => 'required|string|max:200',
            'nama_tka_pemohon'       => 'required|string|max:200',
            'alamat_lks'             => 'required|string',
            'permohonan_rptka'       => 'required|in:Baru,Ulang',
            'tanggal_masuk_dokumen'  => 'required|date',
            'documents.*.keterangan' => 'nullable|string',
            'documents.*.file'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $jenisChanged = $rptka->permohonan_rptka !== $request->permohonan_rptka;

            $rptka->update([
                'nama_lks'              => $request->nama_lks,
                'nama_tka_pemohon'      => $request->nama_tka_pemohon,
                'alamat_lks'            => $request->alamat_lks,
                'permohonan_rptka'      => $request->permohonan_rptka,
                'tanggal_masuk_dokumen' => $request->tanggal_masuk_dokumen,
                'status_permohonan'     => 'Menunggu', // reset ke menunggu setelah edit
            ]);

            if ($jenisChanged) $rptka->initializeDocumentStatuses();

            if ($request->has('documents')) {
                foreach ($request->documents as $docId => $docData) {
                    $status   = rptkaDocumentStatus::where('rptka_id', $rptka->id)
                                    ->where('master_document_id', $docId)->first();
                    $filePath = $status?->file_path;

                    if (isset($docData['file']) && $docData['file']->isValid()) {
                        if ($filePath) Storage::disk('public')->delete($filePath);
                        $file     = $docData['file'];
                        $filename = 'rptka_' . $rptka->id . '_' . $docId . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('rptka_documents', $filename, 'public');
                    }

                    rptkaDocumentStatus::updateOrCreate(
                        ['rptka_id' => $rptka->id, 'master_document_id' => $docId],
                        [
                            'is_ada'     => isset($docData['is_ada']) ? true : false,
                            'keterangan' => $docData['keterangan'] ?? null,
                            'file_path'  => $filePath,
                        ]
                    );
                }
            }

            $rptka->updateCompletionDate();
            DB::commit();

            return redirect()->route('rptka.show', $rptka->id)
                ->with('success', 'Data RPTKA berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $rptka = rptka::findOrFail($id);

        if (auth()->user()->role === 'user' && $rptka->user_id !== auth()->id()) abort(403);

        foreach ($rptka->documentStatuses as $status) {
            if ($status->file_path) Storage::disk('public')->delete($status->file_path);
        }
        if ($rptka->surat_rekomendasi_rptka_path) {
            Storage::disk('public')->delete($rptka->surat_rekomendasi_rptka_path);
        }
        if ($rptka->surat_rekomendasi_rptka_final_path) {
            Storage::disk('public')->delete($rptka->surat_rekomendasi_rptka_final_path);
        }

        $rptka->delete();

        return redirect()->route('rptka.index')->with('success', 'Data RPTKA berhasil dihapus.');
    }

    // ===================== ADMIN =====================

    public function adminIndex(Request $request)
    {
        $adminKabkota = auth()->user()->kabupaten_kota;
        $query = rptka::with('user');

        // Filter berdasarkan kabupaten/kota admin yang login
        // Jika RPTKA tidak punya kabupaten_kota (data lama), tetap tampilkan
        if ($adminKabkota) {
            $query->where(function($q) use ($adminKabkota) {
                $q->where('kabupaten_kota', $adminKabkota)
                  ->orWhereNull('kabupaten_kota');
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lks', 'like', "%{$search}%")
                  ->orWhere('nama_tka_pemohon', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_permohonan', $request->status);
        }

        $rptkas = $query->latest()->paginate(15);

        $baseStats = rptka::query();
        if ($adminKabkota) {
            $baseStats->where(function($q) use ($adminKabkota) {
                $q->where('kabupaten_kota', $adminKabkota)
                  ->orWhereNull('kabupaten_kota');
            });
        }

        $stats = [
            'total'        => (clone $baseStats)->count(),
            'menunggu'     => (clone $baseStats)->where('status_permohonan', 'Menunggu')->count(),
            'diterima'     => (clone $baseStats)->where('status_permohonan', 'Diterima')->count(),
            'ditolak'      => (clone $baseStats)->where('status_permohonan', 'Ditolak')->count(),
            'dikembalikan' => (clone $baseStats)->where('status_permohonan', 'Dikembalikan')->count(),
            'terverifikasi'=> (clone $baseStats)->where('status_permohonan', 'Terverifikasi')->count(),
        ];

        return view('admin.rptka.index', compact('rptkas', 'stats'));
    }

    public function adminVerification($id)
    {
        $rptka = rptka::with(['documentStatuses.masterDocument', 'user'])->findOrFail($id);
        return view('admin.rptka.verification', compact('rptka'));
    }

    public function adminProcessVerification(Request $request, $id)
    {
        $rptka = rptka::findOrFail($id);

        $request->validate([
            'status_permohonan'       => 'required|in:Diterima,Ditolak,Dikembalikan',
            'alasan_penolakan'        => 'required_if:status_permohonan,Ditolak',
            'alasan_dikembalikan'     => 'required_if:status_permohonan,Dikembalikan',
            'surat_rekomendasi_rptka' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('surat_rekomendasi_rptka')) {
            if ($rptka->surat_rekomendasi_rptka_path) {
                Storage::disk('public')->delete($rptka->surat_rekomendasi_rptka_path);
            }
            $file     = $request->file('surat_rekomendasi_rptka');
            $filename = 'surat_rekomendasi_rptka_' . $rptka->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('surat_rekomendasi_rptka', $filename, 'public');
            $rptka->surat_rekomendasi_rptka_path = $path;
        }

        $rptka->status_permohonan   = $request->status_permohonan;
        $rptka->alasan_penolakan    = $request->alasan_penolakan;
        $rptka->alasan_dikembalikan = $request->alasan_dikembalikan;
        $rptka->nama_verifikator    = auth()->user()->name;
        $rptka->save();

        return redirect()->route('admin.rptka.index')
            ->with('success', 'Verifikasi RPTKA berhasil diproses.');
    }

    public function adminDownloadSuratRekomendasi($id)
    {
        $rptka = rptka::findOrFail($id);
        if (!$rptka->surat_rekomendasi_rptka_path || !Storage::disk('public')->exists($rptka->surat_rekomendasi_rptka_path)) {
            abort(404, 'Surat rekomendasi RPTKA tidak ditemukan');
        }
        return Storage::disk('public')->download($rptka->surat_rekomendasi_rptka_path);
    }

    public function adminPreviewSuratRekomendasi($id)
    {
        $rptka = rptka::findOrFail($id);
        if (!$rptka->surat_rekomendasi_rptka_path || !Storage::disk('public')->exists($rptka->surat_rekomendasi_rptka_path)) {
            abort(404, 'Surat rekomendasi RPTKA tidak ditemukan');
        }
        $file     = Storage::disk('public')->get($rptka->surat_rekomendasi_rptka_path);
        $mimeType = Storage::disk('public')->mimeType($rptka->surat_rekomendasi_rptka_path);
        return response($file, 200)->header('Content-Type', $mimeType);
    }

    // ===================== SUPER ADMIN =====================

    public function superAdminIndex(Request $request)
    {
        // Hanya tampilkan yang sudah ada surat rekomendasi dari admin (status Diterima)
        $query = rptka::with('user')
            ->where('status_permohonan', 'Diterima')
            ->whereNotNull('surat_rekomendasi_rptka_path');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lks', 'like', "%{$search}%")
                  ->orWhere('nama_tka_pemohon', 'like', "%{$search}%");
            });
        }

        if ($request->filled('has_final')) {
            if ($request->has_final == 'yes') {
                $query->whereNotNull('surat_rekomendasi_rptka_final_path');
            } else {
                $query->whereNull('surat_rekomendasi_rptka_final_path');
            }
        }

        $rptkas = $query->latest()->paginate(15);

        $stats = [
            'total'         => rptka::where('status_permohonan', 'Diterima')->whereNotNull('surat_rekomendasi_rptka_path')->count(),
            'belum_verval'  => rptka::where('status_permohonan', 'Diterima')->whereNotNull('surat_rekomendasi_rptka_path')->whereNull('surat_rekomendasi_rptka_final_path')->count(),
            'sudah_verval'  => rptka::where('status_permohonan', 'Diterima')->whereNotNull('surat_rekomendasi_rptka_final_path')->count(),
            'terverifikasi' => rptka::where('status_permohonan', 'Terverifikasi')->count(),
        ];

        return view('superadmin.rptka.index', compact('rptkas', 'stats'));
    }

    public function superAdminVerification($id)
    {
        $rptka = rptka::with(['documentStatuses.masterDocument', 'user'])->findOrFail($id);

        if (!$rptka->surat_rekomendasi_rptka_path || $rptka->status_permohonan !== 'Diterima') {
            return redirect()->route('superadmin.rptka.index')
                ->with('error', 'RPTKA ini belum memiliki surat rekomendasi dari admin.');
        }

        return view('superadmin.rptka.verification', compact('rptka'));
    }

    public function superAdminProcessVerification(Request $request, $id)
    {
        $rptka = rptka::findOrFail($id);

        if (!$rptka->surat_rekomendasi_rptka_path || $rptka->status_permohonan !== 'Diterima') {
            return redirect()->route('superadmin.rptka.index')
                ->with('error', 'RPTKA ini belum memiliki surat rekomendasi dari admin.');
        }

        $request->validate([
            'surat_rekomendasi_rptka_final' => 'required|file|mimes:pdf|max:5120',
            'nama_verifikator_superadmin'   => 'required|string',
        ]);

        if ($rptka->surat_rekomendasi_rptka_final_path) {
            Storage::disk('public')->delete($rptka->surat_rekomendasi_rptka_final_path);
        }

        $file     = $request->file('surat_rekomendasi_rptka_final');
        $filename = 'surat_rekomendasi_rptka_final_' . $rptka->id . '_' . time() . '.pdf';
        $path     = $file->storeAs('surat_rekomendasi_rptka_final', $filename, 'public');

        $rptka->surat_rekomendasi_rptka_final_path  = $path;
        $rptka->nama_verifikator_superadmin         = $request->nama_verifikator_superadmin;
        $rptka->status_permohonan                   = 'Terverifikasi';
        $rptka->save();

        return redirect()->route('superadmin.rptka.index')
            ->with('success', 'Verval RPTKA berhasil. Surat rekomendasi final telah diterbitkan.');
    }

    public function superAdminDownloadSuratFinal($id)
    {
        $rptka = rptka::findOrFail($id);
        if (!$rptka->surat_rekomendasi_rptka_final_path || !Storage::disk('public')->exists($rptka->surat_rekomendasi_rptka_final_path)) {
            abort(404, 'Surat rekomendasi final tidak ditemukan');
        }
        return Storage::disk('public')->download($rptka->surat_rekomendasi_rptka_final_path);
    }

    public function superAdminPreviewSuratFinal($id)
    {
        $rptka = rptka::findOrFail($id);
        if (!$rptka->surat_rekomendasi_rptka_final_path || !Storage::disk('public')->exists($rptka->surat_rekomendasi_rptka_final_path)) {
            abort(404, 'Surat rekomendasi final tidak ditemukan');
        }
        $file     = Storage::disk('public')->get($rptka->surat_rekomendasi_rptka_final_path);
        $mimeType = Storage::disk('public')->mimeType($rptka->surat_rekomendasi_rptka_final_path);
        return response($file, 200)->header('Content-Type', $mimeType);
    }

    // ===================== DOKUMEN =====================

    public function previewDocument($id, $docId)
    {
        $status = rptkaDocumentStatus::where('rptka_id', $id)
                    ->where('master_document_id', $docId)->firstOrFail();

        if (!$status->file_path || !Storage::disk('public')->exists($status->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        $file     = Storage::disk('public')->get($status->file_path);
        $mimeType = Storage::disk('public')->mimeType($status->file_path);
        return response($file, 200)->header('Content-Type', $mimeType);
    }

    public function downloadDocument($id, $docId)
    {
        $status = rptkaDocumentStatus::where('rptka_id', $id)
                    ->where('master_document_id', $docId)->firstOrFail();

        if (!$status->file_path || !Storage::disk('public')->exists($status->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($status->file_path);
    }

    // User download surat rekomendasi final
    public function downloadSuratFinal($id)
    {
        $rptka = rptka::findOrFail($id);

        if (auth()->user()->role === 'user' && $rptka->user_id !== auth()->id()) abort(403);

        if (!$rptka->surat_rekomendasi_rptka_final_path || !Storage::disk('public')->exists($rptka->surat_rekomendasi_rptka_final_path)) {
            abort(404, 'Surat rekomendasi belum tersedia');
        }

        return Storage::disk('public')->download($rptka->surat_rekomendasi_rptka_final_path);
    }
}
