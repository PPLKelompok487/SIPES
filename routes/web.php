<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('home');
});

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Login route (placeholder - dikerjakan PBI 2)
Route::get('/login', function () {
    return '<h1>Halaman Login</h1><p>Fitur login akan dibuat selanjutnya</p><p><a href="/register">Kembali ke Register</a></p>';
})->name('login');

// =====================================================================
// ROUTE SEMENTARA: Simulasi login untuk testing Kelola Profil (PBI 3)
// HAPUS route ini setelah PBI 2 (Login) selesai!
// =====================================================================
Route::get('/dev-login', function () {
    $user = \App\Models\User::first();
    if ($user) {
        Auth::login($user);
        return redirect()->route('profile.show')->with('info', '[DEV] Login sebagai: ' . $user->name);
    }
    return 'Tidak ada user. Jalankan: php artisan tinker --execute="App\Models\User::create([...])"';
})->name('dev.login');
// =====================================================================

// Profile routes (PBI 3 - Kelola Profil)
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/',          [ProfileController::class, 'show'])->name('show');
    Route::get('/edit',      [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update',    [ProfileController::class, 'update'])->name('update');
    Route::get('/password',  [ProfileController::class, 'editPassword'])->name('edit-password');
    Route::put('/password',  [ProfileController::class, 'updatePassword'])->name('update-password');
});
