<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AkumulasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REDIRECT ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (HARUS LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ================= ADMIN =================
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin', fn () => view('admin.dashboard'))->name('dashboard');

        Route::get('/pesan', fn () => view('admin.pesan'))->name('pesan');

        Route::get('/scan', [ScanController::class, 'index'])->name('scan');
        Route::post('/scan', [ScanController::class, 'find'])->name('scan.find');

        Route::get('/akumulasi/{id}', [AkumulasiController::class, 'create'])
            ->name('akumulasi.create');

        Route::post('/akumulasi/store', [AkumulasiController::class, 'store'])
            ->name('akumulasi.store');

        Route::get('/cetak', fn () => view('admin.cetak'))->name('cetak');
        Route::get('/riwayat', fn () => view('admin.riwayat'))->name('riwayat');
    });


    /*
    |--------------------------------------------------------------------------
    | ================= GURU =================
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:guru'])->group(function () {

        Route::get('/guru', function () {
            return view('guru.dashboard');
        })->name('guru.dashboard');

    });


    /*
    |--------------------------------------------------------------------------
    | ================= SISWA =================
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:siswa'])->group(function () {

        Route::get('/siswa', function () {
            return view('siswa.dashboard');
        })->name('siswa.dashboard');

        Route::get('/siswa/chat', function () {
            return view('siswa.chat');
        })->name('siswa.chat');

    });


    /*
    |--------------------------------------------------------------------------
    | ================= ORANG TUA =================
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:ortu'])->group(function () {

        Route::get('/ortu', function () {
            return view('ortu.dashboard');
        })->name('ortu.dashboard');

        Route::get('/ortu/riwayat', function () {
            return view('ortu.riwayat');
        })->name('ortu.riwayat');

    });

});