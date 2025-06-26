<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use app\Http\Controllers\UserController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AdminController;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// Route untuk proses login dan register
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth.check'])->group(function () {
    
    // Dashboard utama - accessible by all roles
    Route::get('/daftarKegiatan', [KegiatanController::class, 'index'])->name('daftarKegiatan');
    
    // Routes untuk Mahasiswa dan semua role
    Route::get('/daftarUser', [UserController::class, 'index'])->name('daftarUser');
    
    // Routes khusus Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/manageKegiatan', [AdminController::class, 'manageKegiatan'])->name('manageKegiatan');
        Route::get('/manageUser', [AdminController::class, 'manageUser'])->name('manageUser');
        Route::get('/approveKegiatan', [AdminController::class, 'approveKegiatan'])->name('approveKegiatan');
        Route::get('/buatUser', [AdminController::class, 'buatUser'])->name('buatUser');
    });
    
    // Routes khusus Dosen
    Route::middleware(['role:dosen'])->group(function () {
        Route::get('/kelolaKegiatan', [KegiatanController::class, 'kelola'])->name('kelolaKegiatan');
        Route::get('/laporanMahasiswa', [KegiatanController::class, 'laporan'])->name('laporanMahasiswa');
    });
    
    // Routes khusus Himpunan
    Route::middleware(['role:himpunan'])->group(function () {
        Route::get('/buatKegiatan', [KegiatanController::class, 'create'])->name('buatKegiatan');
        Route::get('/kegiatanSaya', [KegiatanController::class, 'myActivities'])->name('kegiatanSaya');
        Route::get('/anggotaHimpunan', [UserController::class, 'anggotaHimpunan'])->name('anggotaHimpunan');
    });
});