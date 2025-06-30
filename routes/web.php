<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/persyaratan', [HomeController::class, 'persyaratan'])->name('persyaratan');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/ppdb', [PpdbController::class, 'index'])->name('form-ppdb');
    Route::post('/store', [PpdbController::class, 'store'])->name('ppdb.submit');
    Route::get('/pendaftar', [AdminController::class, 'index'])->name('admin.pendaftar');
    Route::get('/admin/data', [AdminController::class, 'data'])->name('admin.data');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    // Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/admin/detail/{id}', [AdminController::class, 'show'])->name('admin.detail');
    Route::put('/admin/update-jadwal', [AdminController::class, 'updateJadwal'])->name('admin.update-jadwal');
    Route::put('/admin/update-hasil', [AdminController::class, 'updateHasil'])->name('admin.update-hasil');
    Route::put('/admin/update-daftarulang', [AdminController::class, 'updateDaftarUlang'])->name('admin.update-daftarulang');
});

require __DIR__ . '/auth.php';
