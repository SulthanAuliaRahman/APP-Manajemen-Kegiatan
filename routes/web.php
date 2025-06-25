<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.loginPage');
});

Route::get('/register', function () {
    return view('auth.registerPage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('/logout', function () {
    session()->forget('user_id');
    session()->forget('name');
    return redirect('/login');
})->name('logout');
