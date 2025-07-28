<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/persyaratan', [HomeController::class, 'persyaratan'])->name('persyaratan');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/ppdb', [PpdbController::class, 'index'])->name('form-ppdb');
    Route::get('/add/data', [AdminController::class, 'addData'])->name('admin.form-ppdb');

    Route::post('/ppdb/{id}/upload-bukti', [PpdbController::class, 'uploadBukti'])->name('ppdb.uploadBukti');

    Route::post('/store', [PpdbController::class, 'store'])->name('ppdb.submit');
    Route::get('/pendaftar', [AdminController::class, 'index'])->name('admin.pendaftar');
    Route::get('/admin/data', [AdminController::class, 'data'])->name('admin.data');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/persyaratan', [HomeController::class, 'storePersyaratan']);
    Route::post('/store/data', [AdminController::class, 'storeData'])->name('store.data');
    Route::post('/persyaratan', [HomeController::class, 'storePersyaratan']);
    Route::put('/persyaratan/{id}', [HomeController::class, 'updatePersyaratan']);
    Route::delete('/persyaratan/{id}', [HomeController::class, 'destroyPersyaratan']);

    Route::post('banners', [HomeController::class, 'storeBanner'])->name('banners.store');
    Route::put('banners/{id}', [HomeController::class, 'updateBanner'])->name('banners.update');
    Route::delete('banners/{id}', [HomeController::class, 'destroyBanner'])->name('banners.destroy');

    Route::post('/faq', [HomeController::class, 'storeFaq']);
    Route::put('/faq/{id}', [HomeController::class, 'updateFaq']);
    Route::delete('/faq/{id}', [HomeController::class, 'destroyFaq']);

    Route::patch('/admin/ppdb/{id}', [AdminController::class, 'update'])->name('admin.ppdb.update');
    // Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/ppdb/detail/{id}', [AdminController::class, 'show'])->name('admin.detail');
    Route::put('/admin/update-jadwal', [AdminController::class, 'updateJadwal'])->name('admin.update-jadwal');
    Route::put('/admin/update-hasil', [AdminController::class, 'updateHasil'])->name('admin.update-hasil');
    Route::put('/admin/update-daftarulang', [AdminController::class, 'updateDaftarUlang'])->name('admin.update-daftarulang');

    Route::post('/setting/toggle', [AdminController::class, 'toggle'])->name('setting.toggle');
    Route::delete('/data/{id}/hapus', [AdminController::class, 'destroy'])->name('admin.route.hapus');
});

require __DIR__ . '/auth.php';
