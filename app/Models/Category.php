<?php

// ------------------------------------------------------------------
// File: app/Models/Category.php
// Fungsi: Model Eloquent untuk tabel "categories" (kategori artikel).
// ------------------------------------------------------------------

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Daftar kolom yang boleh diisi massal: name dan slug.
#[Fillable(['name', 'slug'])]
class Category extends Model
{
    // Tabel tidak memakai kolom timestamps otomatis.
    public $timestamps = false;

    /**
     * Relasi "hasMany": satu kategori memiliki banyak artikel (post).
     * Dipakai untuk mengambil semua post milik kategori,
     * misalnya $category->posts.
     */
    public function posts(): HasMany
    {
        // FK category_id di tabel posts menghubungkan ke kategori ini.
        return $this->hasMany(Post::class);
    }
}
