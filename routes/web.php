<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TernakController;
use App\Http\Controllers\InventoryBarangController;
use App\Http\Controllers\InventoryMasukController;
use App\Http\Controllers\InventoryKeluarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;

// ─── AUTH ───────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── SEMUA USER (admin + peternak) ──────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/pengaturan/profile',  [PengaturanController::class, 'profileIndex'])->name('pengaturan.profile');
    Route::put('/pengaturan/profile',  [PengaturanController::class, 'profileUpdate'])->name('pengaturan.profile.update');

    // Data Ternak — semua user bisa akses
    Route::resource('ternak', TernakController::class);

    // Inventory — semua user bisa LIHAT
    Route::get('/inventory/barang',         [InventoryBarangController::class, 'index'])->name('inventory.barang.index');
    Route::get('/inventory/masuk',          [InventoryMasukController::class, 'index'])->name('inventory.masuk.index');
    Route::get('/inventory/keluar',         [InventoryKeluarController::class, 'index'])->name('inventory.keluar.index');
});

// ─── ADMIN ONLY ──────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Inventory — admin bisa tambah/edit/hapus
    Route::get('/inventory/barang/create',          [InventoryBarangController::class, 'create'])->name('inventory.barang.create');
    Route::post('/inventory/barang',                [InventoryBarangController::class, 'store'])->name('inventory.barang.store');
    Route::get('/inventory/barang/{barang}/edit',   [InventoryBarangController::class, 'edit'])->name('inventory.barang.edit');
    Route::put('/inventory/barang/{barang}',        [InventoryBarangController::class, 'update'])->name('inventory.barang.update');
    Route::delete('/inventory/barang/{barang}',     [InventoryBarangController::class, 'destroy'])->name('inventory.barang.destroy');

    Route::get('/inventory/masuk/create',           [InventoryMasukController::class, 'create'])->name('inventory.masuk.create');
    Route::post('/inventory/masuk',                 [InventoryMasukController::class, 'store'])->name('inventory.masuk.store');
    Route::delete('/inventory/masuk/{barangMasuk}', [InventoryMasukController::class, 'destroy'])->name('inventory.masuk.destroy');

    Route::get('/inventory/keluar/create',              [InventoryKeluarController::class, 'create'])->name('inventory.keluar.create');
    Route::post('/inventory/keluar',                    [InventoryKeluarController::class, 'store'])->name('inventory.keluar.store');
    Route::delete('/inventory/keluar/{barangKeluar}',   [InventoryKeluarController::class, 'destroy'])->name('inventory.keluar.destroy');

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/ternak',             [LaporanController::class, 'ternak'])->name('ternak');
        Route::get('/ternak/pdf',         [LaporanController::class, 'ternakPdf'])->name('ternak.pdf');
        Route::get('/inventory',          [LaporanController::class, 'inventory'])->name('inventory');
        Route::get('/inventory/pdf',      [LaporanController::class, 'inventoryPdf'])->name('inventory.pdf');
    });

    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/user',                   [PengaturanController::class, 'user'])->name('user');
        Route::get('/user/create',            [PengaturanController::class, 'userCreate'])->name('user.create');
        Route::post('/user',                  [PengaturanController::class, 'userStore'])->name('user.store');
        Route::get('/user/{user}/edit',       [PengaturanController::class, 'userEdit'])->name('user.edit');
        Route::put('/user/{user}',            [PengaturanController::class, 'userUpdate'])->name('user.update');
        Route::delete('/user/{user}',         [PengaturanController::class, 'userDestroy'])->name('user.destroy');
    });
});
