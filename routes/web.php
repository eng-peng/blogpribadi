<?php

// ------------------------------------------------------------------
// File: routes/web.php
// Fungsi: Mendefinisikan semua rute (URL) aplikasi dan menghubungkan
//         setiap URL ke Controller beserta method yang akan dipanggil.
// ------------------------------------------------------------------

// Impor class controller yang akan digunakan di rute-rute di bawah ini.
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ------------------------------------------------------------------
// AREA PUBLIK (dapat diakses tanpa login)
// ------------------------------------------------------------------

// Rute beranda: menampilkan daftar semua artikel.
// URL "/" -> HomeController@index -> view home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute detail artikel: menampilkan satu artikel berdasarkan ID.
// URL "/post/{id}" -> HomeController@show -> view post
Route::get('/post/{id}', [HomeController::class, 'show'])->name('post.show');

// ------------------------------------------------------------------
// AUTENTIKASI (login & logout)
// ------------------------------------------------------------------

// Menampilkan halaman form login (GET).
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Memproses submit form login (POST) -> validasi kredensial.
Route::post('/login', [AuthController::class, 'login']);

// Memproses logout (POST) -> mengakhiri sesi pengguna.
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ------------------------------------------------------------------
// AREA ADMIN (wajib login, dilindungi middleware 'auth')
// Semua rute di bawah memiliki prefix URL "/admin".
// ------------------------------------------------------------------
Route::prefix('admin')->middleware('auth')->group(function () {

    // Dashboard admin: menampilkan statistik jumlah post & kategori.
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Rute resource untuk CRUD artikel (posts), kecuali halaman "show".
    // Otomatis menghasilkan rute: index, create, store, edit, update, destroy.
    Route::resource('posts', PostController::class)
        ->except(['show'])
        ->names('admin.posts');

    // Rute resource untuk CRUD kategori (categories), hanya index/store/update/destroy.
    // Tidak ada form create/edit terpisah karena pakai modal.
    Route::resource('categories', CategoryController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.categories');
});
