<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= ADMIN =================
Route::middleware(['role:admin'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
    // Route::get('/admin', fn() => view('admin.dashboard'));
    // Route::get('/admin/chat', fn() => view('admin.chat'));
    Route::get('/admin/scan', fn () => view('admin.scan'));
    // Route::get('/admin/akumulasi', fn() => view('admin.akumulasi'));
    // Route::get('/admin/log', fn() => view('admin.log'));

});

// ================= GURU =================
Route::middleware(['role:guru'])->group(function () {

    Route::get('/guru', function () {
        return view('guru.dashboard');
    });

});

// ================= SISWA =================
Route::middleware(['role:siswa'])->group(function () {

    Route::get('/siswa', function () {
        return view('siswa.dashboard');
    });

    Route::get('/siswa/chat', function () {
        return view('siswa.chat');
    });

});

// ================= ORTU =================
Route::middleware(['role:ortu'])->group(function () {

    Route::get('/ortu', function () {
        return view('ortu.dashboard');
    });

    Route::get('/ortu/riwayat', function () {
        return view('ortu.riwayat');
    });
});
