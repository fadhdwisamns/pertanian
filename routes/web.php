<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\KelompokTaniController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LaporanMasalahController;

// Redirect halaman utama ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rute yang bisa diakses semua user yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-sig', [DashboardController::class, 'sig'])->name('dashboard.sig');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('users', UserController::class);
     Route::get('kelompok-tani/report', [KelompokTaniController::class, 'report'])->name('kelompok-tani.report');

    Route::get('kelompok-tani/cetak-pdf', [KelompokTaniController::class, 'cetakPdf'])->name('kelompok-tani.cetak-pdf');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/lahan/cetak', [ReportController::class, 'cetakLahan'])->name('reports.lahan.cetak');


});

// Rute untuk peran 'petani' DAN 'komoditas' (bisa mengelola lahan sendiri)
Route::middleware(['auth', 'role:Petani|Admin'])->group(function () {
    Route::resource('lahan', LahanController::class);

    Route::resource('laporan-masalah', LaporanMasalahController::class);
});

// Rute untuk peran 'admin' DAN 'komoditas' (bisa mengakses data komoditas)
Route::middleware(['auth', 'role:Admin|Komoditas'])->group(function () {
    // Admin bisa CRUD, Komoditas bisa melihat
    Route::get('/komoditas', [KomoditasController::class, 'index'])->name('komoditas.index');
});

// Rute KHUSUS untuk 'admin'
Route::middleware(['auth', 'role:Admin|Komoditas'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('kelompok-tani', KelompokTaniController::class);
    Route::get('kelompok-tani/report', [KelompokTaniController::class, 'report'])->name('kelompok-tani.report');
    
    // Admin bisa melakukan Create, Update, Delete pada Komoditas
    Route::resource('komoditas', KomoditasController::class)->except(['index']);


});


require __DIR__.'/auth.php';