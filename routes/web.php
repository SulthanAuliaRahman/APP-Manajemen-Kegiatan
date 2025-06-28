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
    
    Route::post('/daftarKegiatan/register/{kegiatanId}', [KegiatanController::class, 'register'])->name('kegiatan.register');
    
    // Routes khusus Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/manageKegiatan', [AdminController::class, 'manageKegiatan'])->name('manageKegiatan');
        Route::get('/manageUser', [AdminController::class, 'manageUser'])->name('manageUser');
        Route::get('/approveKegiatan', [AdminController::class, 'approveKegiatan'])->name('approveKegiatan');
        Route::get('/admin/getUser/{userId}', [AdminController::class, 'getUser'])->name('admin.getUser');
        Route::post('/admin/createUser', [AdminController::class, 'createUser'])->name('admin.createUser');
        Route::put('/admin/updateUser/{userId}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
        Route::delete('/admin/deleteUser/{userId}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
        
    });
    
    // Routes for Dosen only (approval management)
    Route::middleware(['roles:dosen,admin'])->group(function () {
        Route::get('/manageApprovals', [KegiatanController::class, 'manageApprovals'])->name('manageApprovals');
        Route::post('/kegiatan/approve/{kegiatanId}', [KegiatanController::class, 'approve'])->name('kegiatan.approve');
        Route::post('/kegiatan/unapprove/{kegiatanId}', [KegiatanController::class, 'unapprove'])->name('kegiatan.unapprove');
    });
    
    // Routes khusus Himpunan
    Route::middleware(['role:himpunan'])->group(function () {
        Route::get('/buatKegiatan', [KegiatanController::class, 'create'])->name('buatKegiatan');
        Route::get('/kegiatanSaya', [KegiatanController::class, 'myActivities'])->name('kegiatanSaya');
        Route::post('/buatKegiatan', [KegiatanController::class, 'store'])->name('buatKegiatan.store');
        Route::post('/buatKegiatan/update/{kegiatanId}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    });
});