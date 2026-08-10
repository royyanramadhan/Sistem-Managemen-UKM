<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UkmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KepengurusanController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KeanggotaanController;
use App\Http\Controllers\BeritaController;
use Illuminate\Support\Facades\Artisan;

// Temporary route to run migrations from browser
Route::get('/migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "Migration successful! Output: <br><pre>" . Artisan::output() . "</pre><br><a href='/'>Go back to home</a>";
    } catch (\Exception $e) {
        return "Migration failed: " . $e->getMessage();
    }
});

// Temporary route to run database seeders from browser
Route::get('/seed', function () {
    try {
        Artisan::call('db:seed', ['--force' => true]);
        return "Database Seeded successfully! Output: <br><pre>" . Artisan::output() . "</pre><br><a href='/'>Go back to home</a>";
    } catch (\Exception $e) {
        return "Seeding failed: " . $e->getMessage();
    }
});

// ==================== SISI PUBLIK / USER ====================

// Landing Page (beranda publik, tanpa login)
Route::get('/', [DashboardController::class, 'landing'])->name('landing');

// Informasi publik UKM (tanpa login) - untuk pengunjung website
Route::get('informasi-ukm/{ukm}', [DashboardController::class, 'publicShow'])->name('ukm.public.show');

// Detail kegiatan publik (tanpa login) - untuk pengunjung website
Route::get('kegiatan/{kegiatan}', [KegiatanController::class, 'show'])->name('kegiatan.show');

// Detail prestasi publik (tanpa login) - untuk pengunjung website
Route::get('prestasi-publik/{prestasi}', [PrestasiController::class, 'publicShow'])->name('prestasi.public.show');

// ==================== AUTH ====================

// Login User (pengunjung/mahasiswa) - terpisah dari admin
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'userLogin'])->name('login.post');

// Login Admin - terpisah
Route::get('login/admin', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('login/admin', [AuthController::class, 'adminLogin'])->name('admin.login.post');

// Register akun user
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// ==================== MENU USER (butuh login user) ====================

// Daftar UKM (daftar semua UKM + status pendaftaran saya)
Route::prefix('daftar')->middleware('member')->group(function () {
    Route::get('/', [KeanggotaanController::class, 'index'])->name('daftar.index');
    // Form pendaftaran per UKM
    Route::get('{ukm}/create', [KeanggotaanController::class, 'create'])->name('daftar.create');
    Route::post('/', [KeanggotaanController::class, 'store'])->name('daftar.store');
});

// Status Pendaftaran user
Route::get('status-pendaftaran', [KeanggotaanController::class, 'statusPendaftaran'])->name('pendaftaran.status')->middleware('member');

// Profil User
Route::middleware('member')->group(function () {
    Route::get('profil', [KeanggotaanController::class, 'showProfile'])->name('profil');
    Route::put('profil', [KeanggotaanController::class, 'updateProfile'])->name('profil.update');
});

// ==================== SISI ADMIN (kelola sistem) ====================

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('keanggotaan', [KeanggotaanController::class, 'adminIndex'])->name('admin.keanggotaan');
    Route::post('keanggotaan/{keanggotaan}/approve', [KeanggotaanController::class, 'approve'])->name('admin.keanggotaan.approve');
    Route::post('keanggotaan/{keanggotaan}/reject', [KeanggotaanController::class, 'reject'])->name('admin.keanggotaan.reject');

    // Notifikasi Admin
    Route::get('notifications', [DashboardController::class, 'notifications'])->name('admin.notifications');
    Route::post('notifications/{id}/read', [DashboardController::class, 'markNotificationRead'])->name('admin.notifications.read');
    Route::post('notifications/read-all', [DashboardController::class, 'markAllNotificationsRead'])->name('admin.notifications.readall');
});

// Admin CRUD Routes (dilindungi middleware admin)
Route::middleware('admin')->group(function () {
    // UKM Routes
    Route::prefix('ukm')->group(function () {
        Route::get('/', [UkmController::class, 'index'])->name('ukm.index');
        Route::get('create', [UkmController::class, 'create'])->name('ukm.create');
        Route::post('/', [UkmController::class, 'store'])->name('ukm.store');
        Route::get('{ukm}', [UkmController::class, 'show'])->name('ukm.show');
        Route::get('{ukm}/edit', [UkmController::class, 'edit'])->name('ukm.edit');
        Route::put('{ukm}', [UkmController::class, 'update'])->name('ukm.update');
        Route::delete('{ukm}', [UkmController::class, 'destroy'])->name('ukm.destroy');
    });

// User / Data Anggota Routes
    // Anggota berasal dari kepengurusan yang dibuat otomatis saat pendaftaran disetujui.
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        // Detail anggota (berdasarkan record kepengurusan)
        Route::get('member/{kepengurusan}', [UserController::class, 'show'])->name('user.show');
        // Ubah jabatan & status anggota
        Route::post('member/{kepengurusan}/jabatan', [UserController::class, 'updateJabatan'])->name('user.jabatan');
        Route::post('member/{kepengurusan}/status', [UserController::class, 'toggleStatus'])->name('user.status');

        // Routes lama (ARSIP - dinonaktifkan). Anggota tidak boleh ditambah manual
        // dan data pribadi tidak boleh diubah oleh admin.
        // Route::get('create', [UserController::class, 'create'])->name('user.create');
        // Route::post('/', [UserController::class, 'store'])->name('user.store');
        // Route::get('{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        // Route::put('{user}', [UserController::class, 'update'])->name('user.update');
        // Route::delete('{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // Prestasi Routes
    Route::prefix('prestasi')->group(function () {
        Route::get('/', [PrestasiController::class, 'index'])->name('prestasi.index');
        Route::get('create', [PrestasiController::class, 'create'])->name('prestasi.create');
        Route::post('/', [PrestasiController::class, 'store'])->name('prestasi.store');
        Route::get('{prestasi}', [PrestasiController::class, 'show'])->name('prestasi.show');
        Route::get('{prestasi}/edit', [PrestasiController::class, 'edit'])->name('prestasi.edit');
        Route::put('{prestasi}', [PrestasiController::class, 'update'])->name('prestasi.update');
        Route::delete('{prestasi}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');
    });

    // Berita Routes
    Route::prefix('berita')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
        Route::get('create', [BeritaController::class, 'create'])->name('berita.create');
        Route::post('/', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('{berita}', [BeritaController::class, 'update'])->name('berita.update');
        Route::delete('{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
        Route::patch('{berita}/toggle-dashboard', [BeritaController::class, 'toggleDashboard'])->name('berita.toggle-dashboard');
    });

    // Kegiatan Routes
    Route::post('kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::delete('kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

// Kepengurusan Routes
Route::post('ukm/{ukm}/kepengurusan', [KepengurusanController::class, 'store'])->name('kepengurusan.store');
    Route::put('kepengurusan/{kepengurusan}', [KepengurusanController::class, 'update'])->name('kepengurusan.update');
    Route::delete('kepengurusan/{kepengurusan}', [KepengurusanController::class, 'destroy'])->name('kepengurusan.destroy');
Route::post('kepengurusan/{kepengurusan}/keluar', [KepengurusanController::class, 'keluar'])->name('kepengurusan.keluar');

    // Divisi Routes (nested per-UKM -- divisi dimiliki oleh UKM)
    Route::post('ukm/{ukm}/divisi', [DivisiController::class, 'store'])->name('divisi.store');
    Route::put('ukm/{ukm}/divisi/{divisi}', [DivisiController::class, 'update'])->name('divisi.update');
    Route::delete('ukm/{ukm}/divisi/{divisi}', [DivisiController::class, 'destroy'])->name('divisi.destroy');
});
