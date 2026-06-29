<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SopirController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Sopir\ProfileController;
use App\Http\Controllers\Sopir\SubmissionController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\BarcodeController;
use App\Http\Controllers\Admin\BarcodeResetController;
use App\Http\Controllers\Sopir\BarcodeController as SopirBarcodeController;
use App\Http\Controllers\Sopir\BarcodeResetController as SopirBarcodeResetController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Sopir\ChatController as SopirChatController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Sopir\NotificationController as SopirNotificationController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Sopir\DashboardController as SopirDashboardController;
use App\Http\Controllers\Auth\RegisterController;

// ============================================================
// REDIRECT ROOT & ADMIN BASE
// ============================================================
Route::get('/', function () {
    return redirect()->route('sopir.login');
});

Route::get('/admin', function () {
    return redirect()->route('admin.login');
});

Route::get('/login', function () {
    return redirect()->route('sopir.login');
})->name('login');

// ============================================================
// ROUTE AUTENTIKASI — hanya bisa diakses jika BELUM login
// ============================================================
Route::middleware(['guest'])
    ->group(function () {

        Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])
            ->name('admin.login');

        Route::get('/sopir/login', [LoginController::class, 'showSopirLoginForm'])
            ->name('sopir.login');

        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
            ->name('register');

        Route::post('/register', [RegisterController::class, 'register'])
            ->name('register.store');
    });

// POST login — throttle numerik, tidak butuh named limiter
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post')
    ->middleware('throttle:5,1');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ============================================================
// ROUTE ADMIN
// ============================================================
Route::middleware([
        'auth',
        'role:admin,manajemen_driver,senior_manager',
        'throttle:60,1',
    ])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ── Dashboard ──────────────────────────────────────────
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // ── Sopir & Manajemen User ─────────────────────────────
        Route::get('/data-sopir', [SopirController::class, 'index'])
            ->name('sopir.index');
        Route::post('/sopir', [SopirController::class, 'store'])
            ->name('sopir.store');
        Route::put('/sopir/{sopir}', [SopirController::class, 'update'])
            ->name('sopir.update');
        Route::delete('/sopir/{sopir}', [SopirController::class, 'destroy'])
            ->name('sopir.destroy');
        Route::put('/sopir/{sopir}/toggle-status', [SopirController::class, 'toggleStatus'])
            ->name('sopir.toggle-status');
        Route::get('/manajemen-user', [SopirController::class, 'manageIndex'])
            ->name('manajemen-user');

        // ── Kendaraan ──────────────────────────────────────────
        Route::post('/vehicles', [VehicleController::class, 'store'])
            ->name('vehicles.store');
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])
            ->name('vehicles.update');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])
            ->name('vehicles.destroy');

        // ── Pengajuan ──────────────────────────────────────────
        Route::get('/data-pengajuan', [AdminSubmissionController::class, 'index'])
            ->name('submissions');
        Route::get('/monitoring-pengajuan', [AdminSubmissionController::class, 'monitoring'])
            ->name('monitoring');

        // ── Verifikasi Dokumen ─────────────────────────────────
        Route::get('/verifikasi-dokumen', [DocumentController::class, 'index'])
            ->name('verifikasi');
        Route::post('/verifikasi-dokumen/{submission}', [DocumentController::class, 'process'])
            ->name('verifikasi.process');

        // ── Barcode ────────────────────────────────────────────
        Route::get('/upload-barcode', [BarcodeController::class, 'index'])
            ->name('upload-barcode');
        Route::post('/upload-barcode/{submission}', [BarcodeController::class, 'upload'])
            ->name('upload-barcode.process');
        Route::post('/upload-barcode/{submission}/notify', [BarcodeController::class, 'notify'])
            ->name('upload-barcode.notify');

        // ── Reset Barcode ──────────────────────────────────────
        Route::get('/reset-barcode', [BarcodeResetController::class, 'index'])
            ->name('reset-barcode');
        Route::post('/reset-barcode/{reset}/approve', [BarcodeResetController::class, 'approve'])
            ->name('reset-barcode.approve');
        Route::post('/reset-barcode/{reset}/reject', [BarcodeResetController::class, 'reject'])
            ->name('reset-barcode.reject');

        // ── Chat ───────────────────────────────────────────────
        Route::get('/chat', [ChatController::class, 'index'])
            ->name('chat.index');
        Route::get('/chat/{sopir}', [ChatController::class, 'openChat'])
            ->name('chat.show');
        Route::post('/chat/{chat}/send', [ChatController::class, 'sendMessage'])
            ->name('chat.send');

        // ── Notifikasi ─────────────────────────────────────────
        Route::get('/notifikasi', [NotificationController::class, 'index'])
            ->name('notifikasi');
        Route::get('/kirim-notifikasi', [NotificationController::class, 'create'])
            ->name('kirim-notifikasi');
        Route::post('/kirim-notifikasi', [NotificationController::class, 'send'])
            ->name('kirim-notifikasi.send');
        Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');
        Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
            ->name('notifications.read-all');

        // ── Pengaturan / Profil ────────────────────────────────
        Route::get('/pengaturan', [AdminProfileController::class, 'index'])
            ->name('pengaturan');
        Route::patch('/profile', [AdminProfileController::class, 'updateProfile'])
            ->name('profile.update');
        Route::patch('/profile/password', [AdminProfileController::class, 'updatePassword'])
            ->name('profile.password');
        Route::patch('/profile/preferences', [AdminProfileController::class, 'updatePreferences'])
            ->name('profile.preferences');
    });

// ============================================================
// ROUTE SOPIR
// ============================================================
Route::middleware([
        'auth',
        'role:sopir',
        'throttle:60,1',
    ])
    ->prefix('sopir')
    ->name('sopir.')
    ->group(function () {

        // ── Dashboard ──────────────────────────────────────────
        Route::get('/dashboard', [SopirDashboardController::class, 'index'])
            ->name('dashboard');

        // ── Pengajuan ──────────────────────────────────────────
        Route::get('/pengajuan', [SubmissionController::class, 'create'])
            ->name('pengajuan');
        Route::post('/pengajuan', [SubmissionController::class, 'store'])
            ->name('pengajuan.store');
        Route::get('/status-pengajuan', [SubmissionController::class, 'index'])
            ->name('status-pengajuan');

        // ── Barcode ────────────────────────────────────────────
        Route::get('/barcode', [SopirBarcodeController::class, 'index'])
            ->name('barcode');
        Route::get('/barcode/{barcode}/download', [SopirBarcodeController::class, 'download'])
            ->name('barcode.download');

        // ── Reset Barcode ──────────────────────────────────────
        Route::get('/reset-barcode', [SopirBarcodeResetController::class, 'create'])
            ->name('reset-barcode');
        Route::post('/reset-barcode', [SopirBarcodeResetController::class, 'store'])
            ->name('reset-barcode.store');

        // ── Chat ───────────────────────────────────────────────
        Route::get('/chat', [SopirChatController::class, 'index'])
            ->name('chat.index');
        Route::post('/chat/{chat}/send', [SopirChatController::class, 'sendMessage'])
            ->name('chat.send');

        // ── Profil ─────────────────────────────────────────────
        Route::get('/profil', [ProfileController::class, 'show'])
            ->name('profil');
        Route::put('/profil', [ProfileController::class, 'update'])
            ->name('profil.update');

        // ── Notifikasi ─────────────────────────────────────────
        Route::get('/notifications', [SopirNotificationController::class, 'index'])
            ->name('notifications.index');
        Route::patch('/notifications/{notification}/read', [SopirNotificationController::class, 'markAsRead'])
            ->name('notifications.read');
        Route::patch('/notifications/read-all', [SopirNotificationController::class, 'markAllAsRead'])
            ->name('notifications.read-all');
        Route::get('/notifications/unread-count', [SopirNotificationController::class, 'unreadCount'])
            ->name('notifications.unread-count');

        // ── Update Lokasi GPS ──────────────────────────────────
        Route::post('/update-location', [SopirController::class, 'updateLocation'])
            ->name('update-location');
    });

// ============================================================
// FALLBACK — tangkap semua /admin/* yang tidak terdaftar
// ============================================================
Route::fallback(function (Request $request) {
    if (str_starts_with($request->path(), 'admin')) {
        return redirect()->route('admin.login');
    }
    abort(404);
});