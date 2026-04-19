<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('home');
});

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Login route (placeholder - you may need to create this)
Route::get('/login', function() {
    return '<h1>Halaman Login</h1><p>Fitur login akan dibuat selanjutnya</p><p><a href="/register">Kembali ke Register</a></p>';
})->name('login');
