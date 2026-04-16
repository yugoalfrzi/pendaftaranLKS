<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AnnouncementController extends Controller
{
    /**
     * Display the regulasi page
     */
    public function regulasi()
    {
        // Get regulations from database
        $regulations = Announcement::active()
            ->byType('regulasi')
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'description' => $announcement->description,
                    'file_name' => $announcement->file_name,
                    'file_size' => $announcement->file_size,
                    'download_count' => $announcement->download_count,
                    'category' => $announcement->category,
                    'year' => $announcement->year,
                    'format' => $announcement->format,
                    'icon' => $announcement->icon
                ];
            })->toArray();

       

        return view('announcements.regulasi', compact('regulations'));
    }

    /**
     * Display the panduan page
     */
    public function panduan()
    {
        // Get guides from database
        $guides = Announcement::active()
            ->byType('panduan')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'description' => $announcement->description,
                    'file_name' => $announcement->file_name,
                    'file_size' => $announcement->file_size,
                    'download_count' => $announcement->download_count,
                    'category' => $announcement->category,
                    'format' => $announcement->format,
                    'icon' => $announcement->icon,
                    'last_updated' => $announcement->getDisplayDate()
                ];
            })->toArray();

        // Calculate total size
        $totalSize = Announcement::active()
            ->byType('panduan')
            ->get()
            ->sum(function($announcement) {
                return $this->convertSizeToBytes($announcement->file_size);
            });

        $totalSize = $this->formatBytes($totalSize);


        return view('announcements.panduan', compact('guides', 'totalSize'));
    }

    /**
     * Display the surat page
     */
    public function surat()
    {
        // Get letters from database
        $letters = Announcement::active()
            ->byType('surat')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'description' => $announcement->description,
                    'file_name' => $announcement->file_name,
                    'file_size' => $announcement->file_size,
                    'download_count' => $announcement->download_count,
                    'type' => $announcement->type,
                    'category' => $announcement->category,
                    'format' => $announcement->format,
                    'icon' => $announcement->icon,
                    'date' => $announcement->getDisplayDate()
                ];
            })->toArray();

        $currentYear = date('Y');
        $activeTemplates = count($letters);

        return view('announcements.surat', compact('letters', 'currentYear', 'activeTemplates'));
    }

    /**
     * Show form untuk buat announcement baru
     */
    public function create()
    {
        $announcementTypes = [
            'panduan' => 'Panduan',
            'regulasi' => 'Regulasi', 
            'surat' => 'Surat'
        ];

        $categories = [
            'panduan' => [
                'Pendaftaran', 'Formulir', 'Operasional', 'Monev', 
                'Keuangan', 'Sertifikasi', 'Administrasi', 'Laporan'
            ],
            'regulasi' => [
                'Undang-Undang', 'Peraturan Pemerintah', 'Peraturan Menteri',
                'Peraturan Daerah', 'Surat Edaran', 'Surat Pengajuan'
            ],
            'surat' => [
                'Pengajuan', 'Permohonan', 'Hibah', 'Administrasi', 'Lainnya'
            ]
        ];

        $formats = [
            'PDF' => 'pdf',
            'DOCX' => 'docx', 
            'DOC' => 'doc',
            'PPT' => 'ppt',
            'PPTX' => 'pptx'
        ];

        return view('announcements.create', compact('announcementTypes', 'categories', 'formats'));
    }

    /**
     * Store new announcement
     */
    public function store(Request $request)
    {
        $request->validate([
            'announcement_type' => 'required|in:panduan,regulasi,surat',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'format' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240', // 10MB max
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'date' => 'nullable|date',
            'type' => 'nullable|string' // untuk surat
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . $originalName;
                
                // Store in different folders based on announcement type
                $folder = $request->announcement_type . 's'; // panduans, regulasis, surats
                $filePath = $file->storeAs($folder, $fileName, 'public');
                
                // Prepare data for creation
                $announcementData = [
                    'title' => $request->title,
                    'description' => $request->description,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'file_size' => $this->formatBytes($file->getSize()),
                    'file_type' => $file->getClientOriginalExtension(),
                    'announcement_type' => $request->announcement_type,
                    'category' => $request->category,
                    'format' => $request->format,
                    'last_updated' => now(),
                ];

                // Add optional fields based on announcement type
                if ($request->announcement_type === 'regulasi' && $request->year) {
                    $announcementData['year'] = $request->year;
                }

                if ($request->announcement_type === 'surat') {
                    $announcementData['type'] = $request->type;
                    $announcementData['date'] = $request->date ?: now();
                }

                // Create announcement record
                Announcement::create($announcementData);

                $redirectRoute = match($request->announcement_type) {
                    'panduan' => 'panduan',
                    'regulasi' => 'regulasi',
                    'surat' => 'surat',
                    default => 'panduan'
                };

                return redirect()->route($redirectRoute)
                    ->with('success', 'Dokumen berhasil dibuat!');
            }

            return back()->with('error', 'File upload gagal.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Download announcement file
     */
    public function download(string $type, string $filename): BinaryFileResponse
    {
        $folder = $type . 's'; // panduans, regulasis, surats
        $filePath = $folder . '/' . $filename;
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan: ' . $filename);
        }

        // Update download count
        $announcement = Announcement::where('file_name', $filename)->first();
        if ($announcement) {
            $announcement->incrementDownloadCount();
        }

        $fullPath = Storage::disk('public')->path($filePath);
        $contentType = $this->getMimeType($filename);
        
        return response()->download($fullPath, $filename, [
            'Content-Type' => $contentType,
        ]);
    }

    /**
     * View file (preview) - for PDF files only
     */
    public function viewFile(string $type, string $filename)
    {
        $folder = $type . 's';
        $filePath = $folder . '/' . $filename;
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        // Only allow preview for PDF files
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($extension !== 'pdf') {
            abort(400, 'Preview hanya tersedia untuk file PDF');
        }
        
        $file = Storage::disk('public')->get($filePath);
        
        return response($file, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }

    /**
     * Delete announcement and its file
     */
    public function destroy(int $id)
    {
        try {
            $announcement = Announcement::findOrFail($id);

            // Delete physical file if exists
            if ($announcement->file_path && Storage::disk('public')->exists($announcement->file_path)) {
                Storage::disk('public')->delete($announcement->file_path);
            }

            $type = $announcement->announcement_type;
            $announcement->delete();

            $route = match($type) {
                'panduan' => 'announcements.panduan',
                'regulasi' => 'announcements.regulasi',
                'surat' => 'announcements.surat',
                default => 'dashboard'
            };

            return redirect()->route($route)->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Helper function to convert size to bytes
     */
    private function convertSizeToBytes($size)
    {
        if (is_numeric($size)) return $size;
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $number = (float) preg_replace('/[^0-9.]/', '', $size);
        $unit = strtoupper(preg_replace('/[^A-Z]/', '', $size));
        
        $exponent = array_search($unit, $units);
        return $number * pow(1024, $exponent);
    }

    /**
     * Helper function to format bytes
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Get MIME type for supported file types
     */
    private function getMimeType(string $filename): string
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];
        
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}