<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\LKS\LKSController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\KewenanganKabkotaController;
use App\Http\Controllers\KewenanganProvinsiController;
use App\Http\Controllers\KewenanganKemensosController;
use App\Http\Controllers\HibahLksController;
use App\Http\Controllers\RPTKA\RptkaController;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return redirect()->route('login.show');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Google OAuth
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Approval (super_admin only)
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::post('/users/{id}/approve', [AuthController::class, 'approveUser'])->name('users.approve');
    Route::post('/users/{id}/reject', [AuthController::class, 'rejectUser'])->name('users.reject');
});

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {

    // Dashboard Route
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== SUPER ADMIN ROUTES ====================
    Route::prefix('superadmin')->middleware('superadmin')->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.index');
        Route::get('/pending-users', [SuperAdminController::class, 'pendingUsers'])->name('superadmin.pending-users');
        Route::get('/{id}/verification', [SuperAdminController::class, 'verification'])->name('superadmin.verification');
        Route::post('/{id}/verification', [SuperAdminController::class, 'processVerification'])->name('superadmin.verification.process');
        Route::get('/{id}/edit', [SuperAdminController::class, 'edit'])->name('superadmin.edit');
        Route::put('/{id}', [SuperAdminController::class, 'update'])->name('superadmin.update');
        Route::delete('/{id}', [SuperAdminController::class, 'destroy'])->name('superadmin.destroy');
        
        // Sertifikat routes (file dari super admin)
        Route::get('/{id}/download-surat', [SuperAdminController::class, 'downloadSuratRekomendasi'])->name('superadmin.download-surat');
        Route::get('/{id}/preview-surat', [SuperAdminController::class, 'previewSuratRekomendasi'])->name('superadmin.preview-surat');
        Route::delete('/{id}/delete-surat', [SuperAdminController::class, 'deleteSuratRekomendasi'])->name('superadmin.delete-surat');
        
        // Surat rekomendasi routes (file dari admin - untuk dilihat super admin)
        Route::get('/{id}/download-rekomendasi', [SuperAdminController::class, 'downloadSuratRekomendasiAdmin'])->name('superadmin.download-rekomendasi');
        Route::get('/{id}/preview-rekomendasi', [SuperAdminController::class, 'previewSuratRekomendasiAdmin'])->name('superadmin.preview-rekomendasi');
    });

    // Documents Routes - Super Admin & Admin only
    Route::prefix('documents')->middleware('rolecheck:super_admin,admin')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/{document}', [DocumentController::class, 'show'])->name('documents.show');
        Route::get('/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::put('/{document}', [DocumentController::class, 'update'])->name('documents.update');
        Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    });

    // Kewenangan Routes
    // Kabkota Routes
    Route::prefix('kewenangan-kabkota')->group(function () {
        Route::get('/', [KewenanganKabkotaController::class, 'index'])->name('kewenangan-kabkota.index');

        Route::middleware('rolecheck:super_admin,admin')->group(function () {
            Route::get('/create', [KewenanganKabkotaController::class, 'create'])->name('kewenangan-kabkota.create');
            Route::post('/', [KewenanganKabkotaController::class, 'store'])->name('kewenangan-kabkota.store');
            Route::get('/export-excel', [KewenanganKabkotaController::class, 'exportExcel'])->name('kewenangan-kabkota.export-excel');
            Route::get('/{kewenangan}/edit', [KewenanganKabkotaController::class, 'edit'])->name('kewenangan-kabkota.edit');
            Route::put('/{kewenangan}', [KewenanganKabkotaController::class, 'update'])->name('kewenangan-kabkota.update');
            Route::delete('/{kewenangan}', [KewenanganKabkotaController::class, 'destroy'])->name('kewenangan-kabkota.destroy');
        });

        Route::get('/{kewenangan}', [KewenanganKabkotaController::class, 'show'])->name('kewenangan-kabkota.show');
    });

    // Provinsi Routes
    Route::prefix('kewenangan-provinsi')->group(function () {
        Route::get('/', [KewenanganProvinsiController::class, 'index'])->name('kewenangan-provinsi.index');

        Route::middleware('rolecheck:super_admin,admin')->group(function () {
            Route::get('/create', [KewenanganProvinsiController::class, 'create'])->name('kewenangan-provinsi.create');
            Route::post('/', [KewenanganProvinsiController::class, 'store'])->name('kewenangan-provinsi.store');
            Route::get('/export-excel', [KewenanganProvinsiController::class, 'exportExcel'])->name('kewenangan-provinsi.export-excel');
            Route::get('/{kewenangan}/edit', [KewenanganProvinsiController::class, 'edit'])->name('kewenangan-provinsi.edit');
            Route::put('/{kewenangan}', [KewenanganProvinsiController::class, 'update'])->name('kewenangan-provinsi.update');
            Route::delete('/{kewenangan}', [KewenanganProvinsiController::class, 'destroy'])->name('kewenangan-provinsi.destroy');
        });

        Route::get('/{kewenangan}', [KewenanganProvinsiController::class, 'show'])->name('kewenangan-provinsi.show');
    });

    // Kemensos Routes
    Route::prefix('kewenangan-kemensos')->group(function () {
        Route::get('/', [KewenanganKemensosController::class, 'index'])->name('kewenangan-kemensos.index');

        Route::middleware('rolecheck:super_admin,admin')->group(function () {
            Route::get('/create', [KewenanganKemensosController::class, 'create'])->name('kewenangan-kemensos.create');
            Route::post('/', [KewenanganKemensosController::class, 'store'])->name('kewenangan-kemensos.store');
            Route::get('/export-excel', [KewenanganKemensosController::class, 'exportExcel'])->name('kewenangan-kemensos.export-excel');
            Route::get('/{kewenangan}/edit', [KewenanganKemensosController::class, 'edit'])->name('kewenangan-kemensos.edit');
            Route::put('/{kewenangan}', [KewenanganKemensosController::class, 'update'])->name('kewenangan-kemensos.update');
            Route::delete('/{kewenangan}', [KewenanganKemensosController::class, 'destroy'])->name('kewenangan-kemensos.destroy');
        });

        Route::get('/{kewenangan}', [KewenanganKemensosController::class, 'show'])->name('kewenangan-kemensos.show');
    });

    // Announcements Routes
    Route::prefix('announcements')->group(function () {
        Route::get('/regulasi', [AnnouncementController::class, 'regulasi'])->name('announcements.regulasi');
        Route::get('/panduan', [AnnouncementController::class, 'panduan'])->name('announcements.panduan');
        Route::get('/surat', [AnnouncementController::class, 'surat'])->name('announcements.surat');
        Route::get('/create', [AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/store', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/download/{type}/{filename}', [AnnouncementController::class, 'download'])->name('announcements.download');
        Route::get('/preview/{type}/{filename}', [AnnouncementController::class, 'viewFile'])->name('announcements.preview');
        Route::delete('/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });

    // Routes tanpa prefix untuk kompatibilitas
    Route::get('/regulasi', [AnnouncementController::class, 'regulasi'])->name('regulasi');
    Route::get('/panduan', [AnnouncementController::class, 'panduan'])->name('panduan');
    Route::get('/surat', [AnnouncementController::class, 'surat'])->name('surat');


    // LKS Terdaftar (sudah bersertifikat)
    Route::get('/lks-terdaftar', [LKSController::class, 'terdaftar'])->name('lks.terdaftar');

    // LKS Resource Routes
    Route::prefix('lks')->group(function () {
        // View routes - accessible by all authenticated users
        Route::get('/', [LKSController::class, 'index'])->name('lks.index');
        
        // Pendaftaran LKS - hanya untuk user biasa (bukan admin/super_admin)
        Route::middleware('rolecheck:user')->group(function () {
            Route::get('/create', [LKSController::class, 'create'])->name('lks.create');
            Route::post('/', [LKSController::class, 'store'])->name('lks.store');
        });

        // Edit/Update/Delete - accessible by all authenticated users
        Route::get('/{lks}/edit', [LKSController::class, 'edit'])->name('lks.edit');
        Route::put('/{lks}', [LKSController::class, 'update'])->name('lks.update');
        Route::delete('/{lks}', [LKSController::class, 'destroy'])->name('lks.destroy');

        // View and Delete individual checklist files
        Route::get('/{lks}/documents/{document}/files/{file}', [LKSController::class, 'viewDocument'])->name('lks.files.show');
        Route::delete('/{lks}/documents/{document}/files/{file}', [LKSController::class, 'deleteDocumentFile'])->name('lks.files.destroy');

        // Show route - di bawah agar tidak menangkap /create
        Route::get('/{lks}', [LKSController::class, 'show'])->name('lks.show');
    });

    // ==================== RPTKA ROUTES ====================
    Route::prefix('rptka')->group(function () {
        Route::get('/', [RptkaController::class, 'index'])->name('rptka.index');
        Route::get('/create', [RptkaController::class, 'create'])->name('rptka.create');
        Route::post('/', [RptkaController::class, 'store'])->name('rptka.store');
        Route::get('/{id}/edit', [RptkaController::class, 'edit'])->name('rptka.edit');
        Route::put('/{id}', [RptkaController::class, 'update'])->name('rptka.update');
        Route::delete('/{id}', [RptkaController::class, 'destroy'])->name('rptka.destroy');
        Route::get('/{id}/documents/{docId}/preview', [RptkaController::class, 'previewDocument'])->name('rptka.documents.preview');
        Route::get('/{id}/documents/{docId}/download', [RptkaController::class, 'downloadDocument'])->name('rptka.documents.download');
        Route::get('/{id}/download-surat-final', [RptkaController::class, 'downloadSuratFinal'])->name('rptka.download-surat-final');
        Route::get('/{id}', [RptkaController::class, 'show'])->name('rptka.show');
    });

    // RPTKA Admin Routes
    Route::prefix('admin/rptka')->middleware('admin')->group(function () {
        Route::get('/', [RptkaController::class, 'adminIndex'])->name('admin.rptka.index');
        Route::get('/{id}/verification', [RptkaController::class, 'adminVerification'])->name('admin.rptka.verification');
        Route::post('/{id}/verification', [RptkaController::class, 'adminProcessVerification'])->name('admin.rptka.verification.process');
        Route::get('/{id}/download-surat', [RptkaController::class, 'adminDownloadSuratRekomendasi'])->name('admin.rptka.download-surat');
        Route::get('/{id}/preview-surat', [RptkaController::class, 'adminPreviewSuratRekomendasi'])->name('admin.rptka.preview-surat');
    });

    // RPTKA Super Admin Routes
    Route::prefix('superadmin/rptka')->middleware('superadmin')->group(function () {
        Route::get('/', [RptkaController::class, 'superAdminIndex'])->name('superadmin.rptka.index');
        Route::get('/{id}/verification', [RptkaController::class, 'superAdminVerification'])->name('superadmin.rptka.verification');
        Route::post('/{id}/verification', [RptkaController::class, 'superAdminProcessVerification'])->name('superadmin.rptka.verification.process');
        Route::get('/{id}/download-final', [RptkaController::class, 'superAdminDownloadSuratFinal'])->name('superadmin.rptka.download-final');
        Route::get('/{id}/preview-final', [RptkaController::class, 'superAdminPreviewSuratFinal'])->name('superadmin.rptka.preview-final');
    });

    // ==================== HIBAH LKS ROUTES LENGKAP ====================
    Route::prefix('hibah')->group(function () {
        // Main CRUD Routes
        Route::get('/', [HibahLksController::class, 'index'])->name('hibah.index');
        Route::get('/create', [HibahLksController::class, 'create'])->name('hibah.create');
        Route::post('/', [HibahLksController::class, 'store'])->name('hibah.store');
        Route::get('/{id}', [HibahLksController::class, 'show'])->name('hibah.show');
        Route::get('/{id}/edit', [HibahLksController::class, 'edit'])->name('hibah.edit');
        Route::put('/{id}', [HibahLksController::class, 'update'])->name('hibah.update');
        Route::delete('/{id}', [HibahLksController::class, 'destroy'])->name('hibah.destroy');


        // Menu links in sidebar
        Route::get('/data/{tahun}', [HibahLksController::class, 'data'])->name('hibah.data');
        Route::get('/keuangan/{tahun}', [HibahLksController::class, 'keuangan'])->name('hibah.keuangan');

        // ===== DOKUMEN VERIFIKASI TAHUNAN ROUTES =====
        // Upload dokumen verifikasi tahunan
        Route::post('/{id}/upload-dokumen-verifikasi', [HibahLksController::class, 'uploadDokumenVerifikasi'])
        ->name('hibah.upload-dokumen-verifikasi');

        // Hapus dokumen verifikasi
        Route::delete('/{id}/delete-dokumen-verifikasi', [HibahLksController::class, 'deleteDokumenVerifikasi'])
        ->name('hibah.delete-dokumen-verifikasi');

        // Update status verifikasi (admin only)
        Route::post('/{id}/update-status-verifikasi', [HibahLksController::class, 'updateStatusVerifikasi'])
        ->name('hibah.update-status-verifikasi');

        Route::get('/{id}/documents/preview/dokumen_verifikasi', [HibahLksController::class, 'previewDocument'])
        ->name('hibah.documents.preview.dokumen_verifikasi');

        Route::get('/{id}/documents/download/dokumen_verifikasi', [HibahLksController::class, 'downloadDocument'])
        ->name('hibah.documents.download.dokumen_verifikasi');

        // ===== DOKUMEN PENDUKUNG ROUTES =====
        // Halaman kelola dokumen pendukung - SIMPLIFIED ROUTE
        Route::get('/{id}/documents', [HibahLksController::class, 'documents'])->name('hibah.documents');

        // Upload dokumen pendukung
        Route::post('/{id}/documents/upload', [HibahLksController::class, 'uploadDocument'])->name('hibah.documents.upload');

        // Bulk upload supporting documents (admin only)
        Route::post('/{id}/bulk-upload-supporting', [HibahLksController::class, 'bulkUploadSupportingDocuments'])->name('hibah.bulk-upload-supporting');

        // Hapus dokumen pendukung
        Route::delete('/{id}/documents/delete', [HibahLksController::class, 'deleteDocument'])->name('hibah.documents.delete');

        // Preview dokumen - Lihat di browser
        Route::get('/{id}/documents/preview/{document_type}', [HibahLksController::class, 'previewDocument'])->name('hibah.documents.preview');

        // Download dokumen - Unduh file
        Route::get('/{id}/documents/download/{document_type}', [HibahLksController::class, 'downloadDocument'])->name('hibah.documents.download');

        // View dokumen - Alternatif view
        Route::get('/{id}/documents/view/{document_type}', [HibahLksController::class, 'viewDocument'])->name('hibah.documents.view');
    });

    // ==================== ADMIN PANEL ROUTES (Admin & Super Admin) ====================
    Route::prefix('admin')->middleware('admin')->group(function () {
        // ===== LKS MANAGEMENT ROUTES =====
        Route::prefix('lks')->group(function () {
            Route::get('/', [AdminController::class, 'adminIndex'])->name('admin.lks.index');
            Route::get('/{id}', [AdminController::class, 'show'])->name('admin.show');
            Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
            Route::put('/{id}', [AdminController::class, 'update'])->name('admin.update');
            Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
            Route::get('/{id}/verification', [AdminController::class, 'showVerification'])->name('admin.verification');
            Route::post('/{id}/verification', [AdminController::class, 'verification'])->name('admin.verification.store');
            Route::post('/{id}/verify-documents', [AdminController::class, 'verifyDocuments'])->name('admin.verify-documents');

            Route::prefix('{id}')->group(function () {
                Route::get('/download-sertifikat', [AdminController::class, 'downloadSertifikat'])->name('admin.verification.download-sertifikat');
                Route::get('/preview-sertifikat', [AdminController::class, 'previewSertifikat'])->name('admin.verification.preview-sertifikat');
                Route::delete('/delete-sertifikat', [AdminController::class, 'deleteSertifikat'])->name('admin.verification.delete-sertifikat');
                Route::get('/download-sertifikat-kabkota', [AdminController::class, 'downloadSertifikatKabkota'])->name('admin.verification.download-sertifikat-kabkota');
                Route::get('/preview-sertifikat-kabkota', [AdminController::class, 'previewSertifikatKabkota'])->name('admin.verification.preview-sertifikat-kabkota');
                Route::delete('/delete-sertifikat-kabkota', [AdminController::class, 'deleteSertifikatKabkota'])->name('admin.verification.delete-sertifikat-kabkota');
            });

            Route::post('/bulk-action', [AdminController::class, 'bulkAction'])->name('admin.lks.bulk-action');
            Route::get('/export', [AdminController::class, 'export'])->name('admin.lks.export');
        });

        // ===== HIBAH LKS ADMIN ROUTES =====
        Route::prefix('hibah')->group(function () {
            // Admin documents management
            Route::get('/documents', [HibahLksController::class, 'adminDocuments'])->name('admin.hibah.documents');
            // Route untuk verifikasi dokumen (admin only)
            Route::post('/{id}/update-status-verifikasi', [HibahLksController::class, 'updateStatusVerifikasi'])
            ->name('admin.hibah.update-status-verifikasi');

            // Route dengan parameter untuk operasi spesifik
            Route::prefix('{id}')->group(function () {
                Route::post('/admin-documents', [HibahLksController::class, 'adminDocumentsStore'])->name('admin.hibah.documents.store');
                Route::post('/bulk-upload', [HibahLksController::class, 'adminBulkUpload'])->name('admin.hibah.bulk-upload');
                Route::post('/bulk-delete', [HibahLksController::class, 'adminBulkDelete'])->name('admin.hibah.bulk-delete');

            });

            // Admin export dan statistics
            Route::get('/export/{tahun}', [HibahLksController::class, 'adminExport'])->name('admin.hibah.export');
            Route::get('/statistics/{tahun}', [HibahLksController::class, 'admintatistics'])->name('admin.hibah.statistics');
        });
    });

    // ==================== FILE STORAGE ROUTES ====================
    Route::get('storage/{path}', function ($path) {
        $path = storage_path('app/public/' . $path);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('storage.local')->where('path', '.+');

    Route::get('files/{path}', function ($path) {
        $path = storage_path('app/public/' . $path);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    })->name('files.local')->where('path', '.+');

    Route::get('hibah-files/{path}', function ($path) {
        $path = storage_path('app/public/hibah/' . $path);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);
        $response->header('Content-Disposition', 'inline; filename="' . basename($path) . '"');
        return $response;
    })->name('hibah.files')->where('path', '.+');
});

// ==================== PUBLIC ROUTES ====================
Route::get('up', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now(),
        'app' => config('app.name'),
        'env' => config('app.env')
    ]);
});

Route::get('certificates/{filename}', function ($filename) {
    $path = storage_path('app/public/sertifikat/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    $response->header("Content-Disposition", 'inline; filename="' . $filename . '"');

    return $response;
})->name('certificates.public')->where('filename', '.+');
