<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('home');
});

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Profile routes (PBI 3 - Kelola Profil)
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/',          [ProfileController::class, 'show'])->name('show');
    Route::get('/edit',      [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update',    [ProfileController::class, 'update'])->name('update');
    Route::get('/password',  [ProfileController::class, 'editPassword'])->name('edit-password');
    Route::put('/password',  [ProfileController::class, 'updatePassword'])->name('update-password');
});
