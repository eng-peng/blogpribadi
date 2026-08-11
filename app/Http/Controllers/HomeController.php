<?php

// ------------------------------------------------------------------
// File: app/Http/Controllers/HomeController.php
// Fungsi: Controller untuk halaman publik (beranda & detail artikel).
// ------------------------------------------------------------------

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Menampilkan beranda: daftar semua artikel.
     *
     * Alur: ambil semua Post (ikut data category) dari database,
     * urutkan dari ID terbaru, lalu kirim ke view 'home'.
     */
    public function index()
    {
        // with('category') = eager loading relasi agar tidak N+1 query.
        // orderByDesc('id') = artikel terbaru tampil di urutan atas.
        $posts = Post::with('category')->orderByDesc('id')->get();

        // compact('posts') = ['posts' => $posts], diteruskan ke view.
        return view('home', compact('posts'));
    }

    /**
     * Menampilkan detail satu artikel berdasarkan ID dari URL.
     *
     * @param int $id ID artikel yang diklik dari URL /post/{id}
     */
    public function show($id)
    {
        // findOrFail: cari post; jika tidak ditemukan -> error 404.
        $post = Post::with('category')->findOrFail($id);

        // Kirim data post ke view 'post'.
        return view('post', compact('post'));
    }
}
