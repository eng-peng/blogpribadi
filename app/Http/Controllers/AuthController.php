<?php

// ------------------------------------------------------------------
// File: app/Http/Controllers/AuthController.php
// Fungsi: Controller untuk proses autentikasi (login & logout)
//         menggunakan autentikasi manual dengan kolom name & password.
// ------------------------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     * Jika pengguna sudah login, langsung dialihkan ke dashboard admin.
     */
    public function showLogin()
    {
        // Auth::check() = cek apakah sudah ada pengguna login pada sesi ini.
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // Belum login -> tampilkan view form login.
        return view('auth.login');
    }

    /**
     * Memproses submit form login.
     * Menerima input name & password, lalu memverifikasi kredensial.
     */
    public function login(Request $request)
    {
        // Validasi input: name dan password wajib diisi bertipe string.
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Auth::attempt = verifikasi kredensial ke tabel users.
        // $request->boolean('remember') = opsi "ingat saya" dari checkbox.
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerasi session id untuk mencegah session fixation attack.
            $request->session()->regenerate();

            // redirect()->intended = ke halaman tujuan awal (atau dashboard).
            return redirect()->intended(route('admin.dashboard'));
        }

        // Gagal login: kembali ke halaman login, tampilkan error,
        // dan pertahankan input 'name' agar tidak perlu diketik ulang.
        return back()
            ->withErrors([
                'name' => 'Akun atau password salah.',
            ])
            ->onlyInput('name');
    }

    /**
     * Memproses logout: mengakhiri sesi autentikasi pengguna.
     */
    public function logout(Request $request)
    {
        // Logout pengguna dari guard yang aktif.
        Auth::logout();

        // Hapus seluruh data session dan buat ulang token CSRF.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembali ke halaman login.
        return redirect()->route('login');
    }
}
