<?php

use App\Http\Controllers\AkumulasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SuratController;
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

        // DASHBOARD ADMIN

        Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/dashboard/data', [DashboardController::class, 'getData']);

        // PESAN ADMIN

        Route::get('/admin/pesan', [ChatController::class, 'index'])->name('admin.pesan');

        Route::get('/admin/chat/list', [ChatController::class, 'getChatList']);
        Route::post('/admin/chat/send', [ChatController::class, 'sendMessage'])->where('id', '[0-9]+');
        Route::get('/admin/chat/{id}', [ChatController::class, 'getMessages']);

        // MANAJEMEN DATA SISWA

        Route::get('/manajemen', [SiswaController::class, 'index'])->name('admin.manajemen');
        Route::post('/manajemen/store', [SiswaController::class, 'store'])->name('manajemen.store');
        Route::put('/manajemen/update/{id}', [SiswaController::class, 'update'])->name('manajemen.update');
        Route::put('/manajemen/update/{id}', [SiswaController::class, 'update'])->name('manajemen.update');
        Route::delete('/manajemen/delete/{id}', [SiswaController::class, 'destroy'])->name('manajemen.delete');

        // SCAN DATA SISWA

        Route::get('/scan', [ScanController::class, 'index'])->name('scan');
        Route::post('/scan', [ScanController::class, 'find'])->name('scan.find');

        // AKUMULASI SKOR SISWA

        Route::get('/akumulasi/{id}', [AkumulasiController::class, 'create'])->name('akumulasi.create');
        Route::post('/akumulasi/store', [AkumulasiController::class, 'store'])->name('akumulasi.store');

        // CETAK SURAT SISWA

        Route::get('/surat', [SuratController::class, 'index'])->name('surat');
        Route::get('/surat/{id}/preview', [SuratController::class, 'preview'])->name('surat.preview');
        Route::post('/surat/{id}/cetak', [SuratController::class, 'cetak'])->name('surat.cetak');

        // RIWAYAT PELANGGARAN SISWA

        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
        Route::put('/riwayat/{id}/selesai', [RiwayatController::class, 'selesai'])->name('riwayat.selesai');
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

        Route::get('/guru/riwayat', function () {
            return view('guru.riwayat');
        })->name('guru.riwayat');
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

        // PESAN SISWA
        Route::get('/siswa/pesan', [ChatController::class, 'indexSiswa'])->name('siswa.pesan');

        Route::get('/siswa/chat/list', [ChatController::class, 'getChatListSiswa']);
        Route::post('/siswa/chat/send', [ChatController::class, 'sendMessageSiswa']);
        Route::get('/siswa/chat/{id}', [ChatController::class, 'getMessagesSiswa'])->where('id', '[0-9]+');

        Route::get('/siswa/riwayat', function () {
            return view('siswa.riwayat');
        })->name('siswa.riwayat');
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
