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
    {
        $lks = LKS::paginate(10);
        return view('lks.index', compact('lks'));
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
            'pusat_lks' => 'required|string',
            'cabang_lks' => 'required|string',
            'nomor_kontak'=> 'required|string|max:20',
            'tanda_pendaftaran' => 'required|in:Baru,Ulang',
            'tanggal_masuk_dokumen' => 'required|date',
            'tanggal_persyaratan' => 'required|date',
            'documents' => 'required|array',
            'documents.*.document_id' => 'required|exists:documents,id',
            'documents.*.keterangan' => 'nullable|string',
            'documents.*.files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        DB::beginTransaction();
        try {
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
                'pusat_lks' => $request->pusat_lks,
                'cabang_lks' => $request->cabang_lks,
                'nomor_kontak' => $request->nomor_kontak,
                'tanda_pendaftaran' => $request->tanda_pendaftaran,
                'tanggal_masuk_dokumen' => $request->tanggal_masuk_dokumen,
                'tanggal_persyaratan' => $request->tanggal_persyaratan,
                'kabupaten_kota' => $request->lokasi_lks, // SIMPAN KABUPATEN/KOTA DARI LOKASI_LKS
                'pendaftaran_lengkap' => false,
                'status_permohonan' => 'Menunggu',
            ]);

            // Create checklists dengan multiple files
            foreach ($request->documents as $index => $documentData) {
                $kelengkapan = 'Tidak Ada';
                $filePaths = [];
                $originalFilenames = [];
                $fileCount = 0;

                // Handle multiple file uploads
                if (isset($documentData['files']) && is_array($documentData['files'])) {
                    foreach ($documentData['files'] as $fileIndex => $file) {
                        if ($file && $file->isValid()) {
                            $originalFilename = $file->getClientOriginalName();
                            $fileName = time() . '_' . $lks->id . '_' . $documentData['document_id'] . '_' . $fileIndex . '.' . $file->getClientOriginalExtension();
                            $filePath = 'documents/' . $fileName;

                            // Store file
                            Storage::disk('public')->put($filePath, file_get_contents($file));

                            $filePaths[] = $filePath;
                            $originalFilenames[] = $originalFilename;
                            $fileCount++;

                            $kelengkapan = 'Ada';
                        }
                    }
                }

                // Check kelengkapan from hidden input
                if (isset($documentData['kelengkapan']) && $documentData['kelengkapan'] === 'Ada') {
                    $kelengkapan = 'Ada';
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
        $lks = LKS::with('checklists.document')->findOrFail($id);
        $documents = Document::all();

        return view('lks.edit', compact('lks', 'documents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $lks = LKS::findOrFail($id);

            // Validasi data utama LKS
            $validated = $request->validate([
                'nama_lks' => 'required|string|max:255',
                'alamat_lks' => 'required|string',
                'nama_ketua_lks' => 'sometimes|nullable|string|max:255',
                'jenis_pelayanan' => 'sometimes|nullable|string|max:255',
                'jumlah_binaan_dalam_panti' => 'sometimes|nullable|integer|min:0',
                'jumlah_binaan_luar_panti' => 'sometimes|nullable|integer|min:0',
                'lokasi_lks' => 'required|string',
                'pusat_lks' => 'required|string',
                'cabang_lks' => 'required|string',
                'nomor_kontak'=> 'required|string|max:20',
                'tanda_pendaftaran' => 'required|in:Baru,Ulang',
                'tanggal_masuk_dokumen' => 'required|date',
                'tanggal_persyaratan' => 'required|date',
                'documents' => 'sometimes|array',
                'documents.*.document_id' => 'required_with:documents|exists:documents,id',
                'documents.*.keterangan' => 'nullable|string',
                'documents.*.files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            ]);

            // Update data LKS termasuk kabupaten_kota
            $validated['kabupaten_kota'] = $request->lokasi_lks; // UPDATE KABUPATEN/KOTA
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

            return redirect()->route('lks.show', $lks->id)
                ->with('success', 'Data LKS berhasil diperbarui!');

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
