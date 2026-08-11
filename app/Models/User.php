<?php

// ------------------------------------------------------------------
// File: app/Models/User.php
// Fungsi: Model Eloquent untuk tabel "users".
//         Berisi representasi data pengguna & logika relasi/atribut.
// ------------------------------------------------------------------

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// #[Fillable] Mendaftarkan kolom yang boleh diisi massal (mass assignment),
// yaitu hanya 'name' dan 'password' (kolom lain otomatis aman).
#[Fillable(['name', 'password'])]

// #[Hidden] Menyembunyikan kolom sensitif saat model dikonversi
// ke array/JSON agar password & token tidak bocor.
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    // Tabel ini tidak menggunakan kolom created_at / updated_at otomatis.
    public $timestamps = false;

    // HasFactory: mengaktifkan factory untuk seeder/testing.
    // Notifiable: menambahkan kemampuan kirim notifikasi.
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Mendefinisikan cara kolom database dikonversi saat diakses dari model.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Password selalu disimpan/berasosiasi sebagai hash (bcrypt),
            // sehingga tidak pernah disimpan dalam bentuk teks polos.
            'password' => 'hashed',
        ];
    }
}
