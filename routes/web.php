<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.loginPage');
});

Route::get('/register', function () {
    return view('auth.registerPage');
});
