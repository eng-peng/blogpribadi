<?php

// ------------------------------------------------------------------
// File: app/Http/Controllers/Admin/PostController.php
// Fungsi: Controller CRUD (Create, Read, Update, Delete) untuk artikel.
//         Semua method diakses lewat rute resource 'admin/posts'
//         dan dilindungi middleware auth.
// ------------------------------------------------------------------

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Menampilkan daftar semua artikel (halaman kelola artikel).
     */
    public function index()
    {
        // Ambil semua post beserta relasi kategori, urut dari terbaru.
        $posts = Post::with('category')->orderByDesc('id')->get();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Menampilkan form untuk menambah artikel baru.
     * Membutuhkan daftar kategori untuk dropdown pada form.
     */
    public function create()
    {
        // Ambil semua kategori untuk pilihan dropdown di form.
        $categories = Category::orderByDesc('id')->get();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Menyimpan artikel baru ke database (dipanggil via POST).
     */
    public function store(Request $request)
    {
        // Validasi input dari form:
        // - title wajib, string, maksimal 200 karakter
        // - content wajib, string
        // - category_id opsional dan harus ada di tabel categories
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        // Simpan data post baru + isi created_at manual karena
        // model Post mematikan timestamps otomatis.
        Post::create($data + ['created_at' => now()]);

        // Setelah tersimpan, redirect ke daftar artikel dengan pesan sukses.
        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit artikel.
     * Route model binding: parameter $post otomatis berisi data Post dari URL.
     */
    public function edit(Post $post)
    {
        // Ambil daftar kategori untuk dropdown pada form edit.
        $categories = Category::orderByDesc('id')->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Memperbarui data artikel yang sudah ada di database (via PUT).
     */
    public function update(Request $request, Post $post)
    {
        // Validasi input sama seperti saat menyimpan artikel baru.
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        // Update kolom yang berubah pada record post ini.
        $post->update($data);

        // Redirect kembali ke daftar artikel dengan pesan sukses.
        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Menghapus artikel dari database (via DELETE).
     */
    public function destroy(Post $post)
    {
        // Hapus record post yang bersangkutan.
        $post->delete();

        // Redirect kembali ke daftar artikel dengan pesan sukses.
        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
