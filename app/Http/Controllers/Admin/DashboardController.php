<?php

// ------------------------------------------------------------------
// File: app/Http/Controllers/Admin/DashboardController.php
// Fungsi: Controller untuk halaman dashboard admin
//         yang menampilkan statistik ringkas data aplikasi.
// ------------------------------------------------------------------

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan statistik.
     * Mengambil total artikel dan total kategori dari database,
     * lalu mengirimkannya ke view 'admin.dashboard'.
     */
    public function index()
    {
        // Hitung jumlah total artikel di tabel posts.
        $postsCount = Post::count();

        // Hitung jumlah total kategori di tabel categories.
        $categoriesCount = Category::count();

        // Kirim kedua angka statistik ke view dashboard.
        return view('admin.dashboard', compact('postsCount', 'categoriesCount'));
    }
}
