<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AddSecurityHeaders;
use Illuminate\Support\Facades\Route;

// Public routes - accessible without login
Route::middleware([AddSecurityHeaders::class])->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('main');
    Route::get('/peraturan', [PageController::class, 'rules'])->name('peraturan');
    Route::get('/event/sertifikat', [PageController::class, 'sertifikat'])->name('event.sertifikat');
    Route::get('/event/beritaacara', [PageController::class, 'acara'])->name('event.acara');
    Route::get('/aboutus', [PageController::class, 'about'])->name('about');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
});

// Rute login hanya untuk tamu
Route::middleware('guest')->group(function () {
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
});

// Logout harus lewat post dan hanya untuk yang sudah login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Grup rute admin & pelatih
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard utama admin (simple)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman-halaman template dashboard baru
    Route::get('/ecommerce', function () {
        return view('page.dashboard.ecommerce', ['title' => 'Statistik']);
    })->name('ecommerce');

    Route::get('/calendar', function () {
        return view('page.calender', ['title' => 'Calendar']);
    })->name('calendar');

    // Profile untuk admin & pelatih
    Route::controller(\App\Http\Controllers\ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::put('/profile', 'update')->name('profile.update');
        Route::put('/profile/password', 'updatePassword')->name('profile.password.update');
    });

    // Manajemen Kegiatan (Activities)
    Route::resource('activities', \App\Http\Controllers\Admin\ActivityController::class)->except(['create', 'show', 'edit']);

    // Route spesifik untuk schedules harus sebelum resource route
    Route::delete('schedules/{schedule}/participant/{participant}', [\App\Http\Controllers\Admin\ScheduleController::class, 'destroyParticipant'])->name('schedules.participant.destroy');
    Route::post('schedules/{schedule}/quota', [\App\Http\Controllers\Admin\ScheduleController::class, 'updateQuota'])->name('schedules.updateQuota');
    Route::post('schedules/{schedule}/attendance', [\App\Http\Controllers\Admin\ScheduleController::class, 'bulkAttendance'])->name('schedules.attendance.save');

    Route::resource('schedules', \App\Http\Controllers\Admin\ScheduleController::class)->except(['create', 'edit']);
    Route::get('attendance', [\App\Http\Controllers\Admin\ScheduleController::class, 'attendanceList'])->name('attendance.index');
    Route::get('attendance/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'show'])->name('attendance.show');


    Route::resource('achievements', \App\Http\Controllers\AchievementController::class);



    // Resource untuk user management
    Route::resource('users', UserController::class);
});

// Rute khusus untuk atlit
Route::middleware(['auth'])->prefix('atlit')->name('atlit.')->group(function () {
    Route::controller(\App\Http\Controllers\AtlitProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::put('/profile', 'update')->name('profile.update');
        Route::put('/profile/password', 'updatePassword')->name('profile.password.update');
    });

    Route::resource('achievements', \App\Http\Controllers\AchievementController::class)->only(['store', 'destroy', 'update']);

    // Jadwal Latihan Atlit
    Route::controller(\App\Http\Controllers\Atlit\ScheduleController::class)->prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/join', 'join')->name('join');
    });
});