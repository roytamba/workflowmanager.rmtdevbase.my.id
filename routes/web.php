<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::delete('/profile/delete', [AuthController::class, 'destroy'])->name('profile.destroy');

    Route::get('/project', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/project/show/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/project', [ProjectController::class, 'store'])->name('projects.store');

    Route::get('/user', [UserController::class, 'index'])->name('users.index');
    Route::post('/user', [UserController::class, 'store'])->name('users.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('users.update');

    Route::get('/role', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/role', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('roles.update');

    Route::get('/position', [PositionController::class, 'index'])->name('positions.index');
    Route::post('/position', [PositionController::class, 'store'])->name('positions.store');
    Route::put('/position/{id}', [PositionController::class, 'update'])->name('positions.update');

    Route::get('/client', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/client', [ClientController::class, 'store'])->name('clients.store');
    Route::put('/client/{id}', [ClientController::class, 'update'])->name('clients.update');

});
