<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Public reverse location API for report geocoding
Route::get('/location/reverse', [ReportController::class, 'reverseLocation'])->name('location.reverse');

// Report routes
Route::middleware('auth')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
});

// Profile routes (PBI 3 - Kelola Profil)
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/',          [ProfileController::class, 'show'])->name('show');
    Route::get('/edit',      [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update',    [ProfileController::class, 'update'])->name('update');
    Route::get('/password',  [ProfileController::class, 'editPassword'])->name('edit-password');
    Route::put('/password',  [ProfileController::class, 'updatePassword'])->name('update-password');
});

// Laporan routes (FR-05 - Lihat Daftar Laporan)
Route::prefix('laporan')->name('laporan.')->middleware('auth')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');
});
