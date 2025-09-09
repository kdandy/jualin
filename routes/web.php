<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\LogSheetHarianController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanMaggotController;
use App\Http\Controllers\ProfileUsahaController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changepassword'])->name('profile.change-password');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::get('/hakakses', [App\Http\Controllers\HakaksesController::class, 'index'])->name('hakakses.index')->middleware('superadmin');
    Route::get('/hakakses/create', [App\Http\Controllers\HakaksesController::class, 'create'])->name('hakakses.create')->middleware('superadmin');
    Route::post('/hakakses/store', [App\Http\Controllers\HakaksesController::class, 'store'])->name('hakakses.store')->middleware('superadmin');
    Route::get('/hakakses/edit/{id}', [App\Http\Controllers\HakaksesController::class, 'edit'])->name('hakakses.edit')->middleware('superadmin');
    Route::put('/hakakses/update/{id}', [App\Http\Controllers\HakaksesController::class, 'update'])->name('hakakses.update')->middleware('superadmin');
    Route::delete('/hakakses/delete/{id}', [App\Http\Controllers\HakaksesController::class, 'destroy'])->name('hakakses.delete')->middleware('superadmin');



    // Bank Sampah Routes (Admin and Superadmin)
    Route::prefix('bank-sampah')->name('bank-sampah.')->middleware('admin.or.superadmin')->group(function () {
        Route::resource('barang-masuk', BarangMasukController::class);
        Route::get('barang-masuk/export/pdf', [BarangMasukController::class, 'exportPdf'])->name('barang-masuk.export-pdf');
        Route::resource('penjualan', PenjualanController::class);
        Route::get('penjualan/export/pdf', [PenjualanController::class, 'exportPdf'])->name('penjualan.export-pdf');
        Route::resource('stok-barang', StokBarangController::class)->only(['index']);
    });

    // Maggot Routes (Superadmin only)
    Route::prefix('maggot')->name('maggot.')->middleware('superadmin')->group(function () {
        Route::resource('log-sheet-harian', LogSheetHarianController::class);
        Route::resource('pembelian', PembelianController::class);
        Route::get('pembelian/export/pdf', [PembelianController::class, 'exportPdf'])->name('pembelian.export-pdf');
        Route::resource('penjualan', PenjualanMaggotController::class);
        Route::get('penjualan/export/pdf', [PenjualanMaggotController::class, 'exportPdf'])->name('penjualan.export-pdf');
    });

    // Profile Usaha Routes (Admin and Superadmin)
    Route::prefix('profile-usaha')->name('profile-usaha.')->middleware('admin.or.superadmin')->group(function () {
        Route::get('tentang-kami', [ProfileUsahaController::class, 'tentangKami'])->name('tentang-kami');
    });
});