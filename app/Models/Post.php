<?php

// ------------------------------------------------------------------
// File: app/Models/Post.php
// Fungsi: Model Eloquent untuk tabel "posts" (artikel blog).
// ------------------------------------------------------------------

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Daftar kolom yang boleh diisi massal: title, content, category_id.
#[Fillable(['title', 'content', 'category_id'])]
class Post extends Model
{
    // Tabel tidak memakai kolom timestamps otomatis (created_at diisi manual).
    public $timestamps = false;

    /**
     * Relasi "belongsTo": satu artikel (post) dimiliki oleh satu kategori.
     * Dipakai untuk mengakses data kategori dari sebuah post,
     * misalnya $post->category->name.
     */
    public function category(): BelongsTo
    {
        // FK di tabel posts adalah category_id yang merujuk tabel categories.
        return $this->belongsTo(Category::class);
    }

    /**
     * Mendefinisikan konversi tipe data kolom saat diakses.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // created_at otomatis menjadi objek Carbon (datetime)
            // sehingga bisa diformat, mis. ->format('d M Y').
            'created_at' => 'datetime',
        ];
    }
}
