<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvokatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KlientController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes

Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

// Hanya Superadmin
Route::middleware(['role:klien'])->group(function () {
        // Klien upload bukti pembayaran
    Route::get('/pembayaran/{pembayaran}/bayar', function (\App\Models\Pembayaran $pembayaran) {
        return view('pembayaran.bayar', compact('pembayaran'));
    })->name('pembayaran.bayar');

    Route::post('/pembayaran/{pembayaran}/upload', [PembayaranController::class, 'uploadBukti'])
        ->name('pembayaran.upload');
    Route::get('/pembayaran/{pembayaran}/invoice', [PembayaranController::class, 'invoice'])
    ->name('pembayaran.invoice');

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
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/{pembayaran}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
    Route::put('/pembayaran/{pembayaran}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    // Route::post('/pembayaran/{pembayaran}/update', [PembayaranController::class, 'update'])->name('pembayaran.update');
    // Route::post('/pembayaran/{pembayaran}/upload-bukti', [PembayaranController::class, 'uploadBukti'])->name('pembayaran.upload');

    Route::post('/pembayaran/{pembayaran}/konfirmasi', [PembayaranController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');
    Route::get('/pembayaran/bukti/{pembayaran}', [PembayaranController::class, 'previewBukti'])
        ->name('pembayaran.preview')
        ->middleware('auth');
});

// Admin, Keuangan, Advokat, Manajer, Superadmin (Laporan)
Route::middleware(['role:admin,keuangan,advokat,manajer,superadmin'])->group(function () {
    
});

require __DIR__.'/auth.php';
