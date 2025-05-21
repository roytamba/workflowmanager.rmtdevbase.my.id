<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Pengelompokan route berdasarkan status user:
| - Guest       : Belum login
| - Auth        : Sudah login
| - Verified    : Sudah login & email terverifikasi
|
*/

// =======================
// 🔓 GUEST ROUTES
// =======================
Route::middleware('guest')->group(function () {
    Route::get('/', fn() => view('welcome'))->name('home');
});


// =======================
// 🔐 AUTHENTICATED (NOT VERIFIED) ROUTES
// =======================
Route::middleware('auth')->group(function () {


    // Logout (kadang tidak otomatis dari Auth::routes)
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});


// =======================
// ✅ VERIFIED USER ROUTES
// =======================
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');
    Route::get('/profile', fn() => view('profile.index'))->name('profile');
    Route::delete('/profile/delete', [AuthController::class, 'destroy'])->name('profile.destroy');
});
