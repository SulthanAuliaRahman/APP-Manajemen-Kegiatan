<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// Route untuk proses login dan register
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk dashboard (dengan middleware check auth)
Route::get('/dashboard', function () {
    if (!session()->has('user_id')) {
        return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
    }
    
    return view('dashboard', [
        'user' => [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role')
        ]
    ]);
})->name('dashboard');