<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KajianController;
use App\Http\Controllers\KitabController;

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
| USER AREA (LOGIN WAJIB)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [KajianController::class, 'dashboard'])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | KAJIAN
    |--------------------------------------------------------------------------
    */
    Route::controller(KajianController::class)->group(function () {
        Route::get('/kajian', 'index')->name('kajian.index');
        Route::get('/kajian/create', 'create')->name('kajian.create');
        Route::post('/kajian', 'store')->name('kajian.store');
        Route::get('/kajian/{kajian}/edit', 'edit')->name('kajian.edit');
        Route::put('/kajian/{kajian}', 'update')->name('kajian.update');
        Route::delete('/kajian/{kajian}', 'destroy')->name('kajian.destroy');
    });


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
    | DKM (VIEW + CRUD)
    |--------------------------------------------------------------------------
    */
    Route::get('/dkm', [KajianController::class, 'dkm'])->name('dkm.index');
    Route::get('/dkm/create', [KajianController::class, 'dkmCreate'])->name('dkm.create');
    Route::post('/dkm', [KajianController::class, 'dkmStore'])->name('dkm.store');
    Route::get('/dkm/{id}', [KajianController::class, 'dkmDetail'])->name('dkm.show');
    Route::get('/dkm/{id}/edit', [KajianController::class, 'dkmEdit'])->name('dkm.edit');
    Route::put('/dkm/{id}', [KajianController::class, 'dkmUpdate'])->name('dkm.update');
    Route::delete('/dkm/{id}', [KajianController::class, 'dkmDestroy'])->name('dkm.destroy');


    /*
    |--------------------------------------------------------------------------
    | HALAMAN INFORMASI
    |--------------------------------------------------------------------------
    */
    Route::get('/tentang', [KajianController::class, 'tentang'])->name('tentang');
    Route::get('/visi-misi', [KajianController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/kontak', [KajianController::class, 'kontak'])->name('kontak');
    Route::get('/jadwal-kajian', [KajianController::class, 'jadwalKajian'])->name('jadwal.kajian');
    Route::get('/struktur-organisasi', [KajianController::class, 'strukturOrganisasi'])->name('struktur.organisasi');
    Route::get('/faq', [KajianController::class, 'faq'])->name('faq');
    Route::get('/galeri', [KajianController::class, 'galeri'])->name('galeri');
    Route::get('/waktu-sholat', [KajianController::class, 'waktuSholat'])->name('waktu-sholat');




// Logout GET route (redirects to POST for compatibility)
Route::get('/logout', function() {
    return redirect()->route('login');
})->name('logout.get');


    /*
    |--------------------------------------------------------------------------
    | PENGUMUMAN
    |--------------------------------------------------------------------------
    */
    Route::get('/pengumuman', [KajianController::class, 'pengumuman'])->name('pengumuman');


    /*
    |--------------------------------------------------------------------------
    | DONASI
    |--------------------------------------------------------------------------
    */
    Route::get('/donasi', [KajianController::class, 'donasi'])->name('donasi');
    Route::post('/donasi', [KajianController::class, 'donasiStore'])->name('donasi.store');
    Route::get('/donasi/history', [KajianController::class, 'donasiHistory'])->name('donasi.history');
    Route::get('/donasi/{id}', [KajianController::class, 'donasiDetail'])->name('donasi.detail');


    /*
    |--------------------------------------------------------------------------
    | KAS MASJID
    |--------------------------------------------------------------------------
    */
    Route::get('/kas', [KajianController::class, 'kas'])->name('kas');
    Route::post('/kas', [KajianController::class, 'kasStore'])->name('kas.store');

});


/*
|--------------------------------------------------------------------------
| KITAB KAJIAN (PUBLIC ACCESS)
|--------------------------------------------------------------------------
*/
Route::get('/kitab', [KitabController::class, 'index'])->name('kitab.index');
Route::get('/kitab/search', [KitabController::class, 'search'])->name('kitab.search');
Route::get('/kitab/kategori/{kategori}', [KitabController::class, 'kategori'])->name('kitab.kategori');
Route::get('/kitab/{id}', [KitabController::class, 'show'])->name('kitab.show');
Route::get('/kitab/{id}/pdf', [KitabController::class, 'viewPdf'])->name('kitab.pdf');
Route::get('/kitab/{id}/download', [KitabController::class, 'downloadPdf'])->name('kitab.download');


/*
|--------------------------------------------------------------------------
| ADMIN PANEL (KHUSUS ADMIN)
|--------------------------------------------------------------------------
*/

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [KajianController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/', [KajianController::class, 'adminDashboard'])->name('index');
    
    // DKM Management
    Route::get('/dkm', [\App\Http\Controllers\Admin\DkmController::class, 'index'])->name('dkm.index');
    Route::get('/dkm/create', [\App\Http\Controllers\Admin\DkmController::class, 'create'])->name('dkm.create');
    Route::post('/dkm', [\App\Http\Controllers\Admin\DkmController::class, 'store'])->name('dkm.store');
    Route::get('/dkm/{dkm}', [\App\Http\Controllers\Admin\DkmController::class, 'show'])->name('dkm.show');
    Route::get('/dkm/{dkm}/edit', [\App\Http\Controllers\Admin\DkmController::class, 'edit'])->name('dkm.edit');
    Route::put('/dkm/{dkm}', [\App\Http\Controllers\Admin\DkmController::class, 'update'])->name('dkm.update');
    Route::delete('/dkm/{dkm}', [\App\Http\Controllers\Admin\DkmController::class, 'destroy'])->name('dkm.destroy');
    Route::post('/dkm/bulk-delete', [\App\Http\Controllers\Admin\DkmController::class, 'bulkDelete'])->name('dkm.bulkDelete');
    Route::get('/dkm/search', [\App\Http\Controllers\Admin\DkmController::class, 'search'])->name('dkm.search');
    
    // Kajian Management
    Route::get('/kajian', [\App\Http\Controllers\Admin\KajianController::class, 'index'])->name('kajian.index');
    Route::get('/kajian/create', [\App\Http\Controllers\Admin\KajianController::class, 'create'])->name('kajian.create');
    Route::post('/kajian', [\App\Http\Controllers\Admin\KajianController::class, 'store'])->name('kajian.store');
    Route::get('/kajian/{kajian}', [\App\Http\Controllers\Admin\KajianController::class, 'show'])->name('kajian.show');
    Route::get('/kajian/{kajian}/edit', [\App\Http\Controllers\Admin\KajianController::class, 'edit'])->name('kajian.edit');
    Route::put('/kajian/{kajian}', [\App\Http\Controllers\Admin\KajianController::class, 'update'])->name('kajian.update');
    Route::delete('/kajian/{kajian}', [\App\Http\Controllers\Admin\KajianController::class, 'destroy'])->name('kajian.destroy');
    Route::post('/kajian/bulk-delete', [\App\Http\Controllers\Admin\KajianController::class, 'bulkDelete'])->name('kajian.bulkDelete');
    Route::get('/kajian/search', [\App\Http\Controllers\Admin\KajianController::class, 'search'])->name('kajian.search');
    Route::post('/kajian/{kajian}/toggle-status', [\App\Http\Controllers\Admin\KajianController::class, 'toggleStatus'])->name('kajian.toggleStatus');
    
    // Gallery Management
    Route::get('/galeri', [\App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('galeri.index');
    Route::get('/galeri/create', [\App\Http\Controllers\Admin\GalleryController::class, 'create'])->name('galeri.create');
    Route::post('/galeri', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('galeri.store');
    Route::get('/galeri/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'show'])->name('galeri.show');
    Route::get('/galeri/{id}/edit', [\App\Http\Controllers\Admin\GalleryController::class, 'edit'])->name('galeri.edit');
    Route::put('/galeri/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri', [\App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('galeri.destroy');
    Route::post('/galeri/bulk-delete', [\App\Http\Controllers\Admin\GalleryController::class, 'bulkDelete'])->name('galeri.bulkDelete');
    Route::post('/galeri/bulk-upload', [\App\Http\Controllers\Admin\GalleryController::class, 'bulkUpload'])->name('galeri.bulkUpload');
    
    // Pengumuman Management
    Route::get('/pengumuman', [\App\Http\Controllers\Admin\PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/create', [\App\Http\Controllers\Admin\PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman', [\App\Http\Controllers\Admin\PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/{id}', [\App\Http\Controllers\Admin\PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::get('/pengumuman/{id}/edit', [\App\Http\Controllers\Admin\PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [\App\Http\Controllers\Admin\PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [\App\Http\Controllers\Admin\PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    Route::post('/pengumuman/{id}/toggle-status', [\App\Http\Controllers\Admin\PengumumanController::class, 'toggleStatus'])->name('pengumuman.toggleStatus');
    Route::get('/pengumuman/search', [\App\Http\Controllers\Admin\PengumumanController::class, 'search'])->name('pengumuman.search');
    
    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::post('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.resetPassword');
    Route::get('/users/search', [\App\Http\Controllers\Admin\UserController::class, 'search'])->name('users.search');
    Route::post('/users/bulk-delete', [\App\Http\Controllers\Admin\UserController::class, 'bulkDelete'])->name('users.bulkDelete');
    Route::get('/users/export', [\App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');
    
    // Settings Management
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/general', [\App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('settings.updateGeneral');
    Route::post('/settings/masjid', [\App\Http\Controllers\Admin\SettingsController::class, 'updateMasjid'])->name('settings.updateMasjid');
    Route::post('/settings/prayer', [\App\Http\Controllers\Admin\SettingsController::class, 'updatePrayer'])->name('settings.updatePrayer');
    Route::post('/settings/notification', [\App\Http\Controllers\Admin\SettingsController::class, 'updateNotification'])->name('settings.updateNotification');
    Route::post('/settings/maintenance', [\App\Http\Controllers\Admin\SettingsController::class, 'updateMaintenance'])->name('settings.updateMaintenance');
    Route::post('/settings/clear-cache', [\App\Http\Controllers\Admin\SettingsController::class, 'clearCache'])->name('settings.clearCache');
    Route::post('/settings/backup', [\App\Http\Controllers\Admin\SettingsController::class, 'backup'])->name('settings.backup');
});
