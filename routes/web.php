<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvokatController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KlientController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/advokat', [ProfileController::class, 'updateAdvokat'])->name('profile.update.advokat');
    Route::patch('/profile/klien', [ProfileController::class, 'updateKlien'])->name('profile.update.klien');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::resource('/advokats', AdvokatController::class)->except(['show']);
    Route::get('/klients', [KlientController::class, 'index'])->name('klients.index');
});

// Hanya Superadmin
Route::middleware(['role:superadmin'])->group(function () {
    // Route::resource('users', UserManagementController::class)->except(['index']); 
    // misal hanya superadmin bisa create/edit/hapus user
});

// Klien + Admin + Superadmin
Route::middleware(['role:klien,admin,superadmin'])->group(function () {
    // Route::resource('konsultasis', KonsultasiController::class);
});

// Klien, Admin, Advokat, Superadmin (Lihat Konsultasi)
Route::middleware(['role:klien,admin,advokat,superadmin'])->group(function () {
    Route::resource('konsultasis', KonsultasiController::class);
    // Route::get('/konsultasis/{konsultasi}/preview', [KonsultasiController::class, 'previewDokumen'])->name('konsultasis.preview');
    Route::get('dokumen/{dokumen}/preview', [KonsultasiController::class, 'previewDokumen'])
    ->name('dokumens.preview');
    Route::get('/jadwals', [JadwalController::class, 'index'])->name('jadwals.index');
});

// Admin, Advokat, Superadmin (Dokumen)
Route::middleware(['role:admin,advokat,superadmin'])->group(function () {
    Route::prefix('dokumen-hukum')->name('dokumen.hukum.')->group(function () {
            Route::get('/', [DokumenController::class, 'index'])->name('index');
            Route::post('/upload-admin/{konsultasi}', [DokumenController::class, 'uploadAdmin'])->name('upload.admin');
            Route::post('/upload-advokat/{konsultasi}', [DokumenController::class, 'uploadAdvokat'])->name('upload.advokat');
            Route::post('/selesaikan/{konsultasi}', [DokumenController::class, 'selesaikan'])->name('selesaikan');
        });
});

// Keuangan & Superadmin (Pembayaran)
Route::middleware(['role:keuangan,superadmin'])->group(function () {
    
});

// Admin, Keuangan, Advokat, Manajer, Superadmin (Laporan)
Route::middleware(['role:admin,keuangan,advokat,manajer,superadmin'])->group(function () {
    
});

// Laporan
Route::middleware(['role:admin,advokat,superadmin'])->group(function () {
    Route::get('/laporans', [LaporanController::class, 'index'])->name('laporans.index');
    Route::get('/laporans/create', [LaporanController::class, 'create'])->name('laporans.create');
    Route::post('/laporans', [LaporanController::class, 'store'])->name('laporans.store');
    Route::get('/laporans/{laporan}/edit', [LaporanController::class, 'edit'])->name('laporans.edit');
    Route::put('/laporans/{laporan}', [LaporanController::class, 'update'])->name('laporans.update');
    Route::delete('/laporans/{laporan}', [LaporanController::class, 'destroy'])->name('laporans.destroy');
});

require __DIR__.'/auth.php';
