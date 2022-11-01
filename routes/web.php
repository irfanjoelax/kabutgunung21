<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * GROUP ROUTE ADMINISTRATOR
 */
Route::middleware(['auth'])->group(function () {
    // DASHBOARD ADMIN
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);

    // UPDATE PROFILE
    Route::get('/admin/profile', [App\Http\Controllers\ProfileController::class, 'index']);
    Route::post('/admin/profile', [App\Http\Controllers\ProfileController::class, 'update']);

    // MASTER DATA KATEGORI
    Route::get('/admin/kategori', [App\Http\Controllers\KategoriController::class, 'index']);
    Route::get('/admin/kategori/create', [App\Http\Controllers\KategoriController::class, 'create']);
    Route::get('/admin/kategori/edit/{id}', [App\Http\Controllers\KategoriController::class, 'edit']);
    Route::post('/admin/kategori/submit/{id?}', [App\Http\Controllers\KategoriController::class, 'submit']);
    Route::get('/admin/kategori/delete/{id}', [App\Http\Controllers\KategoriController::class, 'delete']);

    // MASTER DATA MARKETPLACE
    Route::get('/admin/marketplace', [App\Http\Controllers\MarketplaceController::class, 'index']);
    Route::get('/admin/marketplace/create', [App\Http\Controllers\MarketplaceController::class, 'create']);
    Route::get('/admin/marketplace/edit/{id}', [App\Http\Controllers\MarketplaceController::class, 'edit']);
    Route::post('/admin/marketplace/submit/{id?}', [App\Http\Controllers\MarketplaceController::class, 'submit']);
    Route::get('/admin/marketplace/delete/{id}', [App\Http\Controllers\MarketplaceController::class, 'delete']);

    // MASTER DATA PRODUK
    Route::get('/admin/produk', [App\Http\Controllers\ProdukController::class, 'index']);
    Route::get('/admin/produk/create', [App\Http\Controllers\ProdukController::class, 'create']);
    Route::get('/admin/produk/edit/{id}', [App\Http\Controllers\ProdukController::class, 'edit']);
    Route::post('/admin/produk/submit/{id?}', [App\Http\Controllers\ProdukController::class, 'submit']);
    Route::get('/admin/produk/delete/{id}', [App\Http\Controllers\ProdukController::class, 'delete']);

    // MASTER DATA PENGELUARAN
    Route::get('/admin/pengeluaran', [App\Http\Controllers\PengeluaranController::class, 'index']);
    Route::get('/admin/pengeluaran/create', [App\Http\Controllers\PengeluaranController::class, 'create']);
    Route::get('/admin/pengeluaran/edit/{id}', [App\Http\Controllers\PengeluaranController::class, 'edit']);
    Route::post('/admin/pengeluaran/submit/{id?}', [App\Http\Controllers\PengeluaranController::class, 'submit']);
    Route::get('/admin/pengeluaran/delete/{id}', [App\Http\Controllers\PengeluaranController::class, 'delete']);

    // MASTER DATA PENJUALAN
    Route::get('/admin/penjualan', [App\Http\Controllers\PenjualanController::class, 'index']);
    Route::get('/admin/penjualan/create', [App\Http\Controllers\PenjualanController::class, 'create']);
    Route::get('/admin/penjualan/show/{id}', [App\Http\Controllers\PenjualanController::class, 'show']);
    Route::get('/admin/penjualan/detail/{id}', [App\Http\Controllers\PenjualanController::class, 'detail']);
    Route::get('/admin/penjualan/update/kurir/{id}', [App\Http\Controllers\PenjualanController::class, 'updateKurir']);
    Route::get('/admin/penjualan/update/bayar/{id}', [App\Http\Controllers\PenjualanController::class, 'updateBayar']);

    // MASTER DATA LAPORAN
    Route::get('/admin/laporan', [App\Http\Controllers\LaporanController::class, 'index']);
});
