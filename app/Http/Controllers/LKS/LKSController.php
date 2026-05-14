<?php

namespace App\Http\Controllers\LKS;

use App\Http\Controllers\Controller;
use App\Models\LKS;
use App\Models\Document;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LKSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        $search = request('search');
        $status = request('status');
        $kewenangan = request('kewenangan');

        $query = LKS::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lks', 'like', "%$search%")
                  ->orWhere('alamat_lks', 'like', "%$search%")
                  ->orWhere('kabupaten_kota', 'like', "%$search%");
            });
        }
        if ($status) {
            $query->where('status_permohonan', $status);
        }
        if ($kewenangan) {
            $query->where('kewenangan_type', $kewenangan);
        }

        $lks = $query->latest()->paginate(15);

        $stats = [
            'total'      => LKS::count(),
            'menunggu'   => LKS::where('status_permohonan', 'Menunggu')->count(),
            'diterima'   => LKS::whereIn('status_permohonan', ['Terekomendasi', 'Disetujui'])->count(),
            'ditolak'    => LKS::where('status_permohonan', 'Ditolak')->count(),
            'dikembalikan' => LKS::where('status_permohonan', 'Dikembalikan')->count(),
        ];

        return view('lks.index', compact('lks', 'stats'));
    }

    public function terdaftar(Request $request)
    {
        $search = $request->search;
        $userId = auth()->id();
        $isUser = auth()->user()->hasRole('user');

        $baseKabkota = LKS::where('kewenangan_type', 'kabkota')
            ->whereNotNull('sertifikat_kabkota_path')
            ->where('sertifikat_kabkota_path', '!=', '');

        $baseProvinsi = LKS::where('kewenangan_type', 'provinsi')
            ->whereNotNull('sertifikat_path')
            ->where('sertifikat_path', '!=', '');

        // Role user hanya melihat data milik akunnya sendiri
        if ($isUser) {
            $baseKabkota->where('user_id', $userId);
            $baseProvinsi->where('user_id', $userId);
        }

        if ($search) {
            $baseKabkota->where(function ($q) use ($search) {
                $q->where('nama_lks', 'like', "%$search%")
                  ->orWhere('kabupaten_kota', 'like', "%$search%")
                  ->orWhere('lokasi_lks', 'like', "%$search%");
            });
            $baseProvinsi->where(function ($q) use ($search) {
                $q->where('nama_lks', 'like', "%$search%")
                  ->orWhere('kabupaten_kota', 'like', "%$search%")
                  ->orWhere('lokasi_lks', 'like', "%$search%");
            });
        }

        $lksKabkota  = (clone $baseKabkota)->latest()->paginate(15, ['*'], 'kabkota_page');
        $lksProvinsi = (clone $baseProvinsi)->latest()->paginate(15, ['*'], 'provinsi_page');

        // Stats juga difilter per user jika role user
        $statsKabkota = LKS::where('kewenangan_type', 'kabkota')->whereNotNull('sertifikat_kabkota_path')->where('sertifikat_kabkota_path', '!=', '');
        $statsProvinsi = LKS::where('kewenangan_type', 'provinsi')->whereNotNull('sertifikat_path')->where('sertifikat_path', '!=', '');
        if ($isUser) {
            $statsKabkota->where('user_id', $userId);
            $statsProvinsi->where('user_id', $userId);
        }
        $stats = [
            'kabkota'  => $statsKabkota->count(),
            'provinsi' => $statsProvinsi->count(),
        ];

        // LKS milik user yang ditolak/dikembalikan (hanya untuk role user)
        $lksPerluPerhatian = null;
        if (auth()->check() && $isUser) {
            $lksPerluPerhatian = LKS::where('user_id', $userId)
                ->whereIn('status_permohonan', ['Ditolak', 'Dikembalikan'])
                ->latest('updated_at')
                ->get();
        }

        return view('lks.terdaftar', compact('lksKabkota', 'lksProvinsi', 'stats', 'lksPerluPerhatian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documents = Document::ordered()->get();
        return view('lks.create', compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lks' => 'required|string|max:255',
            'alamat_lks' => 'required|string',
            'nama_ketua_lks' => 'required|string|max:255',
            'jenis_pelayanan' => 'required|string|max:255',
            'jumlah_binaan_dalam_panti' => 'required|integer|min:0',
            'jumlah_binaan_luar_panti' => 'required|integer|min:0',
            'lokasi_lks' => 'required|string',
            'pusat_lks' => 'required_if:kewenangan_type,provinsi|nullable|string',
            'cabang_lks' => 'required_if:kewenangan_type,provinsi|nullable|string',
            'nomor_kontak'=> 'required|string|max:20',
            'tanda_pendaftaran' => 'required|in:Baru,Perpanjangan',
            'tanggal_masuk_dokumen' => 'required|date',
            'tanggal_persyaratan' => 'nullable|date',
            'kewenangan_type' => 'required|in:kabkota,provinsi',
            'documents' => 'nullable|array',
            'documents.*.document_id' => 'nullable|exists:documents,id',
            'documents.*.keterangan' => 'nullable|string',
            'documents.*.files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:20480',
        ]);

        DB::beginTransaction();
        try {
            // Validasi: dokumen wajib harus ada file
            // documents dikirim dengan index numerik, tiap item punya document_id
            $wajibDocuments = \App\Models\Document::where('wajib', true)->get();
            foreach ($wajibDocuments as $wajibDoc) {
                $found = false;
                if ($request->has('documents')) {
                    foreach ($request->documents as $idx => $docData) {
                        if (isset($docData['document_id']) && $docData['document_id'] == $wajibDoc->id) {
                            // Cek apakah ada file yang diupload untuk dokumen ini
                            if ($request->hasFile("documents.{$idx}.files")) {
                                $files = $request->file("documents.{$idx}.files");
                                foreach ($files as $file) {
                                    if ($file && $file->isValid()) {
                                        $found = true;
                                        break;
                                    }
                                }
                            }
                            break;
                        }
                    }
                }
                if (!$found) {
                    return back()->withInput()->withErrors([
                        'documents' => 'Dokumen wajib "' . $wajibDoc->nama_dokumen . '" harus diupload.'
                    ]);
                }
            }

            // Create LKS dengan kabupaten_kota
            $lks = LKS::create([
                'user_id' => auth()->id(),
                'nama_lks' => $request->nama_lks,
                'alamat_lks' => $request->alamat_lks,
                'nama_ketua_lks' => $request->nama_ketua_lks,
                'jenis_pelayanan' => $request->jenis_pelayanan,
                'jumlah_binaan_dalam_panti' => $request->jumlah_binaan_dalam_panti,
                'jumlah_binaan_luar_panti' => $request->jumlah_binaan_luar_panti,
                'lokasi_lks' => $request->lokasi_lks,
                'pusat_lks' => $request->kewenangan_type === 'provinsi' ? $request->pusat_lks : null,
                'cabang_lks' => $request->kewenangan_type === 'provinsi' ? $request->cabang_lks : null,
                'nomor_kontak' => $request->nomor_kontak,
                'tanda_pendaftaran' => $request->tanda_pendaftaran,
                'tanggal_masuk_dokumen' => $request->tanggal_masuk_dokumen,
                'tanggal_persyaratan' => $request->tanggal_persyaratan,
                'kabupaten_kota' => auth()->user()->kabupaten_kota ?: $request->lokasi_lks,
                'kewenangan_type' => $request->input('kewenangan_type', 'kabkota'),
                'pendaftaran_lengkap' => false,
                'status_permohonan' => 'Menunggu',
            ]);

            // Create checklists dengan multiple files
            foreach ($request->documents as $index => $documentData) {
                $kelengkapan = 'Tidak Ada';
                $filePaths = [];
                $originalFilenames = [];
                $fileCount = 0;

                // Handle multiple file uploads — gunakan $request->file() bukan dari array
                $uploadedFiles = $request->file("documents.{$index}.files") ?? [];
                if (!is_array($uploadedFiles)) $uploadedFiles = [$uploadedFiles];

                foreach ($uploadedFiles as $fileIndex => $file) {
                    if ($file && $file->isValid()) {
                        $originalFilename = $file->getClientOriginalName();
                        $fileName = time() . '_' . $lks->id . '_' . $documentData['document_id'] . '_' . $fileIndex . '.' . $file->getClientOriginalExtension();
                        $filePath = 'documents/' . $fileName;

                        Storage::disk('public')->put($filePath, file_get_contents($file));

                        $filePaths[] = $filePath;
                        $originalFilenames[] = $originalFilename;
                        $fileCount++;
                        $kelengkapan = 'Ada';
                    }
                }

                Checklist::create([
                    'lks_id' => $lks->id,
                    'document_id' => $documentData['document_id'],
                    'kelengkapan' => $kelengkapan,
                    'keterangan' => $documentData['keterangan'] ?? null,
                    'file_paths' => !empty($filePaths) ? $filePaths : null,
                    'original_filenames' => !empty($originalFilenames) ? $originalFilenames : null,
                    'file_count' => $fileCount,
                ]);
            }

            // Check if all required documents are complete
            if ($lks->isComplete()) {
                $lks->update(['pendaftaran_lengkap' => true]);
            }

            DB::commit();

            return redirect()->route('lks.show', $lks->id)
                ->with('success', 'Pendaftaran LKS berhasil dibuat dan menunggu verifikasi.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lks = LKS::with('checklists')->findOrFail($id);
        $documents = Document::all();

        return view('lks.show', compact('lks', 'documents'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Hanya user yang boleh mengedit
        if (!auth()->user()->hasRole('user')) {
            abort(403, 'Hanya user yang dapat mengedit pendaftaran LKS.');
        }

        $lks = LKS::with('checklists.document')->findOrFail($id);

        // User tidak bisa mengedit pendaftaran yang ditolak — harus daftar ulang dari awal
        if (auth()->user()->hasRole('user') && $lks->status_permohonan === 'Ditolak') {
            return redirect()->route('lks.index')
                ->with('error', 'Pendaftaran yang ditolak tidak dapat diedit. Silakan buat pendaftaran baru.');
        }

        $documents = Document::all();

        return view('lks.edit', compact('lks', 'documents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Hanya user yang boleh mengupdate
        if (!auth()->user()->hasRole('user')) {
            abort(403, 'Hanya user yang dapat mengedit pendaftaran LKS.');
        }

        return DB::transaction(function () use ($request, $id) {
            $lks = LKS::findOrFail($id);

            // User tidak bisa mengupdate pendaftaran yang ditolak — harus daftar ulang dari awal
            if (auth()->user()->hasRole('user') && $lks->status_permohonan === 'Ditolak') {
                return redirect()->route('lks.index')
                    ->with('error', 'Pendaftaran yang ditolak tidak dapat diedit. Silakan buat pendaftaran baru.');
            }

            // Validasi data utama LKS
            $validated = $request->validate([
                'nama_lks' => 'required|string|max:255',
                'alamat_lks' => 'required|string',
                'nama_ketua_lks' => 'sometimes|nullable|string|max:255',
                'jenis_pelayanan' => 'sometimes|nullable|string|max:255',
                'jumlah_binaan_dalam_panti' => 'sometimes|nullable|integer|min:0',
                'jumlah_binaan_luar_panti' => 'sometimes|nullable|integer|min:0',
                'lokasi_lks' => 'required|string',
                'pusat_lks' => 'required_if:kewenangan_type,provinsi|nullable|string',
                'cabang_lks' => 'required_if:kewenangan_type,provinsi|nullable|string',
                'nomor_kontak'=> 'required|string|max:20',
                'tanda_pendaftaran' => 'required|in:Baru,Perpanjangan',
                'tanggal_masuk_dokumen' => 'required|date',
                'tanggal_persyaratan' => 'nullable|date',
                'documents' => 'sometimes|array',
                'documents.*.document_id' => 'required_with:documents|exists:documents,id',
                'documents.*.keterangan' => 'nullable|string',
                'documents.*.files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:20480',
            ]);

            // Update data LKS termasuk kabupaten_kota
            $validated['kabupaten_kota'] = $request->lokasi_lks;

            // Jika status Dikembalikan dan yang mengedit adalah user, reset ke Menunggu
            if (
                $lks->status_permohonan === 'Dikembalikan' &&
                auth()->user()->hasRole('user')
            ) {
                $validated['status_permohonan'] = 'Menunggu';
                $validated['alasan_penolakan']    = null;
                $validated['alasan_dikembalikan'] = null;
            }

            $lks->update($validated);

            // Proses checklist documents dengan multiple files
            if ($request->has('documents')) {
                foreach ($request->documents as $index => $documentData) {

                    if (!isset($documentData['document_id'])) {
                        continue;
                    }

                    // Cari checklist yang sudah ada
                    $checklist = Checklist::where('lks_id', $lks->id)
                                        ->where('document_id', $documentData['document_id'])
                                        ->first();

                    // Jika tidak ada checklist, buat baru
                    if (!$checklist) {
                        $checklist = new Checklist();
                        $checklist->lks_id = $lks->id;
                        $checklist->document_id = $documentData['document_id'];
                        $filePaths = [];
                        $originalFilenames = [];
                    } else {
                        // Ambil data files yang sudah ada
                        $filePaths = $checklist->file_paths ?? [];
                        $originalFilenames = $checklist->original_filenames ?? [];
                    }

                    $kelengkapan = $documentData['kelengkapan'] ?? 'Tidak Ada';

                    // Handle multiple file uploads
                    if (isset($documentData['files']) && is_array($documentData['files'])) {
                        foreach ($documentData['files'] as $fileIndex => $file) {
                            if ($file && $file->isValid()) {
                                $originalFilename = $file->getClientOriginalName();
                                $fileName = time() . '_' . $lks->id . '_' . $documentData['document_id'] . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                                $filePath = 'documents/' . $fileName;

                                // Store file
                                Storage::disk('public')->put($filePath, file_get_contents($file));

                                $filePaths[] = $filePath;
                                $originalFilenames[] = $originalFilename;

                                // Auto-set kelengkapan to 'Ada' if files are uploaded
                                $kelengkapan = 'Ada';
                            }
                        }
                    }

                    // Hitung jumlah file
                    $fileCount = count($filePaths);

                    // kelengkapan ditentukan dari jumlah file aktual, bukan dari input form
                    $kelengkapan = $fileCount > 0 ? 'Ada' : 'Tidak Ada';

                    // Update atau buat checklist
                    $checklistData = [
                        'kelengkapan' => $kelengkapan,
                        'keterangan' => $documentData['keterangan'] ?? null,
                        'file_paths' => !empty($filePaths) ? $filePaths : null,
                        'original_filenames' => !empty($originalFilenames) ? $originalFilenames : null,
                        'file_count' => $fileCount,
                    ];

                    if ($checklist->exists) {
                        $checklist->update($checklistData);
                    } else {
                        $checklist->fill($checklistData);
                        $checklist->save();
                    }
                }
            }

            // Update status pendaftaran_lengkap
            $lks->update(['pendaftaran_lengkap' => $lks->isComplete()]);

            $successMsg = in_array($lks->getOriginal('status_permohonan') ?? $lks->status_permohonan, ['Dikembalikan', 'Ditolak']) && auth()->user()->hasRole('user')
                ? 'Data LKS berhasil diperbarui dan dikirim kembali ke admin untuk verifikasi.'
                : 'Data LKS berhasil diperbarui!';

            return redirect()->route('lks.show', $lks->id)
                ->with('success', $successMsg);

        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LKS $lks)
    {
        // Delete associated files
        foreach ($lks->checklists as $checklist) {
            if ($checklist->file_paths && is_array($checklist->file_paths)) {
                foreach ($checklist->file_paths as $filePath) {
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
        }

        $lks->delete();
        return redirect()->route('lks.index')->with('success', 'Data LKS berhasil dihapus!');
    }

    /**
     * View document file
     */
    public function viewDocument(LKS $lks, Checklist $document, $file = 0)
    {
        if ($document->lks_id !== $lks->id) {
            abort(404);
        }

        $filePaths = [];
        if ($document->file_paths) {
            $filePaths = is_array($document->file_paths) ? $document->file_paths : json_decode($document->file_paths, true);
        }

        $filePath = is_array($filePaths) ? ($filePaths[$file] ?? null) : $document->file_path;

        if (!$filePath) {
            abort(404);
        }

        $fullPath = storage_path('app/public/' . $filePath);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $contentTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        $contentType = $contentTypes[$extension] ?? 'application/octet-stream';

        // For Word documents, force download instead of inline preview to avoid blank tabs
        if (in_array($extension, ['doc', 'docx'])) {
            return response()->download($fullPath, basename($fullPath), [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'attachment; filename="' . basename($fullPath) . '"'
            ]);
        }

        return response()->file($fullPath, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"'
        ]);
    }

    /**
     * Delete a specific uploaded file from a checklist (by index)
     */
    public function deleteDocumentFile(LKS $lks, Checklist $document, $file)
    {
        if ($document->lks_id !== $lks->id) {
            abort(404);
        }

        $fileIndex = (int) $file;

        $filePaths = $document->file_paths ?? [];
        $originalFilenames = $document->original_filenames ?? [];

        if (!is_array($filePaths)) {
            $filePaths = json_decode($filePaths, true) ?: [];
        }
        if (!is_array($originalFilenames)) {
            $originalFilenames = json_decode($originalFilenames, true) ?: [];
        }

        if (!array_key_exists($fileIndex, $filePaths)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $pathToDelete = $filePaths[$fileIndex] ?? null;
        if ($pathToDelete && Storage::disk('public')->exists($pathToDelete)) {
            Storage::disk('public')->delete($pathToDelete);
        }

        // Remove the file entry and reindex arrays
        array_splice($filePaths, $fileIndex, 1);
        array_splice($originalFilenames, $fileIndex, 1);

        $filePaths = array_values($filePaths);
        $originalFilenames = array_values($originalFilenames);

        $document->file_paths = !empty($filePaths) ? $filePaths : null;
        $document->original_filenames = !empty($originalFilenames) ? $originalFilenames : null;
        $document->file_count = $document->file_paths ? count($document->file_paths) : 0;

        if ($document->file_count === 0) {
            $document->kelengkapan = 'Tidak Ada';
        }

        $document->save();

        // Update pendaftaran_lengkap on parent LKS
        $lks->update(['pendaftaran_lengkap' => $lks->isComplete()]);

        return back()->with('success', 'File berhasil dihapus.');
    }

    /**
     * Delete all uploaded files for a specific checklist document
     */
    public function deleteAllDocumentFiles(LKS $lks, Checklist $document)
    {
        if ($document->lks_id !== $lks->id) {
            abort(404);
        }

        $filePaths = $document->file_paths ?? [];
        if (!is_array($filePaths)) {
            $filePaths = json_decode($filePaths, true) ?: [];
        }

        // Delete all physical files
        foreach ($filePaths as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        // Reset fields
        $document->file_paths = null;
        $document->original_filenames = null;
        $document->file_count = 0;
        $document->kelengkapan = 'Tidak Ada';
        $document->save();

        // Update parent LKS completeness
        $lks->update(['pendaftaran_lengkap' => $lks->isComplete()]);

        return back()->with('success', 'Semua file untuk dokumen ini berhasil dihapus.');
    }
}
