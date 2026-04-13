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
    |----------------------------------
    | DASHBOARD
    |----------------------------------
    */
    Route::get('/dashboard', [KajianController::class, 'dashboard'])
        ->name('dashboard');


    /*
    |----------------------------------
    | KAJIAN CRUD
    |----------------------------------
    */
    Route::get('/kajian', [KajianController::class, 'index']);
    Route::get('/kajian/create', [KajianController::class, 'create']);
    Route::post('/kajian', [KajianController::class, 'store']);
    Route::get('/kajian/{kajian}/edit', [KajianController::class, 'edit']);
    Route::put('/kajian/{kajian}', [KajianController::class, 'update']);
    Route::delete('/kajian/{kajian}', [KajianController::class, 'destroy']);


    /*
    |----------------------------------
    | RATING + SEARCH + REKOMENDASI
    |----------------------------------
    */
    Route::post('/rating', [KajianController::class, 'rating']);
    Route::get('/search', [KajianController::class, 'search']);
    Route::get('/rekomendasi', [KajianController::class, 'rekomendasi']);


    /*
    |----------------------------------
    | DKM (🔥 FIX 404)
    |----------------------------------
    */
    Route::get('/dkm', [KajianController::class, 'dkm']);
    Route::get('/dkm/{id}', [KajianController::class, 'dkmDetail']);

});
