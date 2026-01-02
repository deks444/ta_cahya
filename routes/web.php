<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AddSecurityHeaders;
use Illuminate\Support\Facades\Route;

// Rute login hanya untuk tamu
Route::middleware('guest')->group(function () {
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
});

// Logout harus lewat post dan hanya untuk yang sudah login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Grup rute admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
});

// Grup rute yang memakai middleware AddSecurityHeaders dan Auth
Route::middleware([AddSecurityHeaders::class, 'auth'])->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('main');
    Route::get('/peraturan', [PageController::class, 'rules'])->name('peraturan');
    Route::get('/event/sertifikat', [PageController::class, 'sertifikat'])->name('event.sertifikat');
    Route::get('/event/beritaacara', [PageController::class, 'acara'])->name('event.acara');
    Route::get('/aboutus', [PageController::class, 'about'])->name('about');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
});