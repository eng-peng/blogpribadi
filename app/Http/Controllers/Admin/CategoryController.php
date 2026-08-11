<?php

// ------------------------------------------------------------------
// File: app/Http/Controllers/Admin/CategoryController.php
// Fungsi: Controller CRUD untuk kategori artikel.
//         Hanya menyediakan index (list), store, update, dan destroy
//         karena form tambah/edit memakai modal di halaman index.
// ------------------------------------------------------------------

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     */
    public function index()
    {
        // Ambil semua kategori, urut dari ID terbaru.
        $categories = Category::orderByDesc('id')->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Menyimpan kategori baru ke database (via POST dari modal).
     */
    public function store(Request $request)
    {
        // Validasi: nama kategori wajib, string, maksimal 100 karakter.
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        // Buat slug otomatis dari nama, mis. "Tutorial Laravel" -> "tutorial-laravel".
        $slug = Str::slug($data['name']);

        // Cegah duplikasi: jika slug sudah dipakai kategori lain, tolak.
        if (Category::where('slug', $slug)->exists()) {
            return back()->with('error', 'Kategori sudah ada.');
        }

        // Simpan kategori baru dengan name dan slug.
        Category::create(['name' => $data['name'], 'slug' => $slug]);

        // Redirect ke daftar kategori dengan pesan sukses.
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Memperbarui data kategori yang ada (via PUT dari modal edit).
     */
    public function update(Request $request, Category $category)
    {
        // Validasi input nama kategori.
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        // Buat ulang slug dari nama baru.
        $slug = Str::slug($data['name']);

        // Cegah duplikasi slug, tapi kecualikan kategori yang sedang diedit.
        if (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            return back()->with('error', 'Kategori sudah ada.');
        }

        // Update name & slug pada record kategori.
        $category->update(['name' => $data['name'], 'slug' => $slug]);

        // Redirect ke daftar kategori dengan pesan sukses.
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * Menghapus kategori dari database (via DELETE).
     */
    public function destroy(Category $category)
    {
        // Hapus record kategori. Post yang terkait diatur nullOnDelete.
        $category->delete();

        // Redirect ke daftar kategori dengan pesan sukses.
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
