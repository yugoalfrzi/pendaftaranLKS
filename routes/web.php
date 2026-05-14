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
    Route::get('/auth/google/complete', [GoogleAuthController::class, 'showCompleteForm'])->name('auth.google.complete');
    Route::post('/auth/google/complete', [GoogleAuthController::class, 'completeRegistration'])->name('auth.google.complete.post');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Approval (super_admin only)
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::post('/users/{id}/approve', [AuthController::class, 'approveUser'])->name('users.approve');
    Route::post('/users/{id}/reject', [AuthController::class, 'rejectUser'])->name('users.reject');
    Route::get('/manage-accounts', [AuthController::class, 'manageAccounts'])->name('users.manage');
    Route::post('/users/{id}/toggle-active', [AuthController::class, 'toggleActive'])->name('users.toggle-active');
    Route::delete('/users/{id}', [AuthController::class, 'deleteUser'])->name('users.delete');
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
        
        // Tanda pendaftaran routes (file dari super admin)
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
        // Index — user akan di-redirect ke create oleh controller
        Route::get('/', [KewenanganKabkotaController::class, 'index'])->name('kewenangan-kabkota.index');

        // Create & Store — user, admin, super_admin
        Route::get('/create', [KewenanganKabkotaController::class, 'create'])->name('kewenangan-kabkota.create');
        Route::post('/', [KewenanganKabkotaController::class, 'store'])->name('kewenangan-kabkota.store');

        // Export — hanya super_admin & admin
        Route::get('/export-excel', [KewenanganKabkotaController::class, 'exportExcel'])
            ->middleware('rolecheck:super_admin,admin')
            ->name('kewenangan-kabkota.export-excel');

        // Edit, Update, Delete — user, admin, super_admin (user bisa edit/hapus data sendiri)
        Route::get('/{kewenangan}/edit', [KewenanganKabkotaController::class, 'edit'])->name('kewenangan-kabkota.edit');
        Route::put('/{kewenangan}', [KewenanganKabkotaController::class, 'update'])->name('kewenangan-kabkota.update');
        Route::delete('/{kewenangan}', [KewenanganKabkotaController::class, 'destroy'])->name('kewenangan-kabkota.destroy');

        // Show — semua role
        Route::get('/{kewenangan}', [KewenanganKabkotaController::class, 'show'])->name('kewenangan-kabkota.show');
    });

    // Provinsi Routes
    Route::prefix('kewenangan-provinsi')->group(function () {
        // Index — user akan di-redirect ke create oleh controller
        Route::get('/', [KewenanganProvinsiController::class, 'index'])->name('kewenangan-provinsi.index');

        // Create & Store — user, admin, super_admin
        Route::get('/create', [KewenanganProvinsiController::class, 'create'])->name('kewenangan-provinsi.create');
        Route::post('/', [KewenanganProvinsiController::class, 'store'])->name('kewenangan-provinsi.store');

        // Export — hanya super_admin & admin
        Route::get('/export-excel', [KewenanganProvinsiController::class, 'exportExcel'])
            ->middleware('rolecheck:super_admin,admin')
            ->name('kewenangan-provinsi.export-excel');

        // Edit, Update, Delete — user, admin, super_admin
        Route::get('/{kewenangan}/edit', [KewenanganProvinsiController::class, 'edit'])->name('kewenangan-provinsi.edit');
        Route::put('/{kewenangan}', [KewenanganProvinsiController::class, 'update'])->name('kewenangan-provinsi.update');
        Route::delete('/{kewenangan}', [KewenanganProvinsiController::class, 'destroy'])->name('kewenangan-provinsi.destroy');

        // Show — semua role
        Route::get('/{kewenangan}', [KewenanganProvinsiController::class, 'show'])->name('kewenangan-provinsi.show');
    });

    // Kemensos Routes — index, show, edit, delete hanya super_admin; create & store user juga bisa
    Route::prefix('kewenangan-kemensos')->group(function () {
        // Index — user akan di-redirect ke create oleh controller
        Route::get('/', [KewenanganKemensosController::class, 'index'])->name('kewenangan-kemensos.index');

        // Create & Store — user, admin, super_admin
        Route::get('/create', [KewenanganKemensosController::class, 'create'])->name('kewenangan-kemensos.create');
        Route::post('/', [KewenanganKemensosController::class, 'store'])->name('kewenangan-kemensos.store');

        // Export — hanya super_admin
        Route::get('/export-excel', [KewenanganKemensosController::class, 'exportExcel'])
            ->middleware('rolecheck:super_admin')
            ->name('kewenangan-kemensos.export-excel');

        // Edit, Update, Delete — hanya super_admin (dihandle di controller)
        Route::get('/{kewenangan}/edit', [KewenanganKemensosController::class, 'edit'])->name('kewenangan-kemensos.edit');
        Route::put('/{kewenangan}', [KewenanganKemensosController::class, 'update'])->name('kewenangan-kemensos.update');
        Route::delete('/{kewenangan}', [KewenanganKemensosController::class, 'destroy'])->name('kewenangan-kemensos.destroy');

        // Show — hanya super_admin (dihandle di controller)
        Route::get('/{kewenangan}', [KewenanganKemensosController::class, 'show'])->name('kewenangan-kemensos.show');
    });

    // Announcements Routes — read-only untuk semua user terautentikasi
    Route::prefix('announcements')->group(function () {
        Route::get('/regulasi', [AnnouncementController::class, 'regulasi'])->name('announcements.regulasi');
        Route::get('/panduan', [AnnouncementController::class, 'panduan'])->name('announcements.panduan');
        Route::get('/surat', [AnnouncementController::class, 'surat'])->name('announcements.surat');
        Route::get('/download/{type}/{filename}', [AnnouncementController::class, 'download'])->name('announcements.download');
        Route::get('/preview/{type}/{filename}', [AnnouncementController::class, 'viewFile'])->name('announcements.preview');
    });

    // Announcements CRUD — hanya super_admin
    Route::prefix('announcements')->middleware('superadmin')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/create', [AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/store', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });

    // Routes tanpa prefix untuk kompatibilitas
    Route::get('/regulasi', [AnnouncementController::class, 'regulasi'])->name('regulasi');
    Route::get('/panduan', [AnnouncementController::class, 'panduan'])->name('panduan');
    Route::get('/surat', [AnnouncementController::class, 'surat'])->name('surat');


    // LKS Terdaftar (sudah memiliki tanda pendaftaran)
    Route::get('/lks-terdaftar', [LKSController::class, 'terdaftar'])->name('lks.terdaftar');

    // Tanda pendaftaran & dokumen LKS — dapat diakses semua role terautentikasi
    Route::get('/lks/{id}/preview-sertifikat-kabkota', [AdminController::class, 'previewSertifikatKabkotaPublic'])->name('lks.preview-sertifikat-kabkota');
    Route::get('/lks/{id}/download-sertifikat-kabkota', [AdminController::class, 'downloadSertifikatKabkotaPublic'])->name('lks.download-sertifikat-kabkota');
    Route::get('/lks/{id}/preview-surat-rekomendasi', [AdminController::class, 'previewSuratRekomendasiPublic'])->name('lks.preview-surat-rekomendasi');
    Route::get('/lks/{id}/download-surat-rekomendasi', [AdminController::class, 'downloadSuratRekomendasiPublic'])->name('lks.download-surat-rekomendasi');
    Route::get('/lks/{id}/preview-sertifikat-provinsi', [AdminController::class, 'previewSertifikatProvinsiPublic'])->name('lks.preview-sertifikat-provinsi');
    Route::get('/lks/{id}/download-sertifikat-provinsi', [AdminController::class, 'downloadSertifikatProvinsiPublic'])->name('lks.download-sertifikat-provinsi');

    // LKS Resource Routes
    Route::prefix('lks')->group(function () {
        // View index - hanya super_admin
        Route::get('/', [LKSController::class, 'index'])->middleware('rolecheck:super_admin')->name('lks.index');

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
        // Static routes FIRST (before /{id} wildcard)
        Route::get('/', [HibahLksController::class, 'index'])->name('hibah.index');
        Route::get('/create', [HibahLksController::class, 'create'])->name('hibah.create');
        Route::post('/', [HibahLksController::class, 'store'])->name('hibah.store');
        Route::get('/keuangan/{tahun}', [HibahLksController::class, 'keuangan'])->name('hibah.keuangan');

        // Dynamic /{id} routes AFTER static routes
        Route::get('/{id}/edit', [HibahLksController::class, 'edit'])->name('hibah.edit');
        Route::put('/{id}', [HibahLksController::class, 'update'])->name('hibah.update');
        Route::delete('/{id}', [HibahLksController::class, 'destroy'])->name('hibah.destroy');

        // Update status verifikasi (admin only)
        Route::post('/{id}/update-status-verifikasi', [HibahLksController::class, 'updateStatusVerifikasi'])
            ->name('hibah.update-status-verifikasi');

        // ===== DOKUMEN PENDUKUNG ROUTES =====
        Route::get('/{id}/documents', [HibahLksController::class, 'documents'])->name('hibah.documents');
        Route::post('/{id}/documents/upload', [HibahLksController::class, 'uploadDocument'])->name('hibah.documents.upload');
        Route::post('/{id}/bulk-upload-supporting', [HibahLksController::class, 'bulkUploadSupportingDocuments'])->name('hibah.bulk-upload-supporting');
        Route::delete('/{id}/documents/delete', [HibahLksController::class, 'deleteDocument'])->name('hibah.documents.delete');
        Route::get('/{id}/documents/preview/{document_type}', [HibahLksController::class, 'previewDocument'])->name('hibah.documents.preview');
        Route::get('/{id}/documents/download/{document_type}', [HibahLksController::class, 'downloadDocument'])->name('hibah.documents.download');

        // Show route LAST (wildcard /{id})
        Route::get('/{id}', [HibahLksController::class, 'show'])->name('hibah.show');
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

// ==================== DEBUG ROUTE ====================
Route::get('debug-mail', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        
        $config = config('mail.mailers.smtp');
        // Masking password for security
        if (isset($config['password'])) {
            $config['password'] = '********'; 
        }

        \Illuminate\Support\Facades\Mail::raw('Ini adalah email test dari sistem debug LKS.', function ($message) {
            $message->to('alfariziprayugo@gmail.com')
                    ->subject('Test Email Debug LKS');
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Email test berhasil dikirim!',
            'smtp_config_used' => $config,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'error_message' => $e->getMessage(),
            'error_trace' => $e->getTraceAsString(),
            'smtp_config_used' => $config ?? 'Belum ter-load',
        ]);
    }
});
