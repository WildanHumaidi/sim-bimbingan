<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->middleware('throttle:10,1')->name('login.post');

    // Registration Routes
    Route::get('/register/mahasiswa', [AuthController::class, 'showMahasiswaRegistrationForm'])->name('register.mahasiswa');
    Route::post('/register/mahasiswa', [AuthController::class, 'registerMahasiswa'])->middleware('throttle:10,1');
    Route::get('/register/dosen', [AuthController::class, 'showDosenRegistrationForm'])->name('register.dosen');
    Route::post('/register/dosen', [AuthController::class, 'registerDosen'])->middleware('throttle:10,1');

    // Socialite Routes
    Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('google.callback');
});
