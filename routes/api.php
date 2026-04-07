<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HibahLksController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ===== DASHBOARD API ROUTES =====
Route::prefix('dashboard')->group(function () {
    Route::get('/statistics', [DashboardController::class, 'getStatistics'])->name('dashboard.statistics');
    Route::get('/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
    Route::get('/kabupaten-data', [DashboardController::class, 'getKabupatenData'])->name('dashboard.kabupaten-data');
    Route::get('/recent-lks', [DashboardController::class, 'getRecentLKS'])->name('dashboard.recent-lks');
});

// ===== HIBAH API ROUTES =====
Route::prefix('hibah')->group(function () {
    Route::get('/statistics/{tahun}', [HibahLksController::class, 'getStatisticsAPI'])->name('hibah.api.statistics');
    Route::get('/data/{tahun}', [HibahLksController::class, 'getHibahData'])->name('hibah.api.data');
    Route::get('/export/{tahun}', [HibahLksController::class, 'exportHibahData'])->name('hibah.api.export');
});

// ===== ADMIN LKS API ROUTES =====
Route::prefix('admin/lks')->group(function () {
    Route::get('/statistics', [AdminController::class, 'getStatistics'])->name('admin.lks.statistics');
});

// Public API route (jika diperlukan)
Route::get('/up', function () {
    return response()->json([
        'status' => 'OK', 
        'timestamp' => now(),
        'app' => config('app.name'),
        'env' => config('app.env')
    ]);
});