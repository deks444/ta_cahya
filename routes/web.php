<?php

use App\Http\Controllers\PageController;
use App\Http\Middleware\AddSecurityHeaders;
use Illuminate\Support\Facades\Route;

// Rute login tanpa middleware
Route::get('/login', [PageController::class, 'login'])->name('login');

// Grup rute yang memakai middleware AddSecurityHeaders
Route::middleware(AddSecurityHeaders::class)->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('main');
    Route::get('/peraturan', [PageController::class, 'rules'])->name('peraturan');
    Route::get('/event/sertifikat', [PageController::class, 'sertifikat'])->name('event.sertifikat');
    Route::get('/event/beritaacara', [PageController::class, 'acara'])->name('event.acara');
    Route::get('/aboutus', [PageController::class, 'about'])->name('about');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
});