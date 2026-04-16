<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KajianController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| SEMUA FITUR (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [KajianController::class, 'dashboard'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | KAJIAN CRUD
    |--------------------------------------------------------------------------
    */
    Route::get('/kajian', [KajianController::class, 'index'])->name('kajian.index');
    Route::get('/kajian/create', [KajianController::class, 'create'])->name('kajian.create');
    Route::post('/kajian', [KajianController::class, 'store'])->name('kajian.store');
    Route::get('/kajian/{kajian}/edit', [KajianController::class, 'edit'])->name('kajian.edit');
    Route::put('/kajian/{kajian}', [KajianController::class, 'update'])->name('kajian.update');
    Route::delete('/kajian/{kajian}', [KajianController::class, 'destroy'])->name('kajian.destroy');


    /*
    |--------------------------------------------------------------------------
    | RATING + SEARCH + REKOMENDASI
    |--------------------------------------------------------------------------
    */
    Route::post('/rating', [KajianController::class, 'rating'])->name('rating');
    Route::get('/search', [KajianController::class, 'search'])->name('search');
    Route::get('/rekomendasi', [KajianController::class, 'rekomendasi'])->name('rekomendasi');


    /*
    |--------------------------------------------------------------------------
    | DKM
    |--------------------------------------------------------------------------
    */
    Route::get('/dkm', [KajianController::class, 'dkm'])->name('dkm.index');
    Route::get('/dkm/{id}', [KajianController::class, 'dkmDetail'])->name('dkm.show');


    /*
    |--------------------------------------------------------------------------
    | TENTANG
    |--------------------------------------------------------------------------
    */
    Route::get('/tentang', [KajianController::class, 'tentang'])->name('tentang');
    Route::get('/kontak', [KajianController::class, 'kontak'])->name('kontak');
    Route::get('/jadwal-kajian', [KajianController::class, 'jadwalKajian'])->name('jadwal.kajian');
    Route::get('/struktur-organisasi', [KajianController::class, 'strukturOrganisasi'])->name('struktur.organisasi');
    Route::get('/faq', [KajianController::class, 'faq'])->name('faq');


    /*
    |--------------------------------------------------------------------------
    | PENGUMUMAN
    |--------------------------------------------------------------------------
    */
    Route::get('/pengumuman', [KajianController::class, 'pengumuman'])->name('pengumuman');


    /*
    |--------------------------------------------------------------------------
    | DONASI (🔥 BARU)
    |--------------------------------------------------------------------------
    */
    Route::get('/donasi', [KajianController::class, 'donasi'])->name('donasi');
    Route::post('/donasi', [KajianController::class, 'donasiStore'])->name('donasi.store');
    Route::get('/donasi/history', [KajianController::class, 'donasiHistory'])->name('donasi.history');

});
