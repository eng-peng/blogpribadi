{{-- ==================================================================
     File: resources/views/auth/login.blade.php
     Fungsi: Halaman form login pengguna.
     Dikirim dari AuthController@showLogin (GET /login).
     ================================================================== --}}

{{-- Gunakan layout utama 'layouts.app' --}}
@extends('layouts.app')

{{-- Judul tab browser --}}
@section('title', 'Login')

{{-- Blok konten utama --}}
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            {{-- Kartu form login --}}
            <div class="card">

                {{-- Header kartu --}}
                <div class="card-header text-center py-4">
                    <h2 class="mb-0"><i class="fas fa-sign-in-alt"></i> Login ke Akun Anda</h2>
                </div>

                <div class="card-body p-4">

                    {{-- Tampilkan error validasi (mis. "Akun atau password salah")
                         yang dikirim oleh AuthController@login via withErrors --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Form login dikirim via POST ke rute 'login' --}}
                    <form method="POST" action="{{ route('login') }}">

                        {{-- @csrf: token keamanan wajib untuk semua form POST --}}
                        @csrf

                        {{-- Input nama/akun. old('name') mengembalikan nilai
                             yang sempat diketik saat login gagal --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-envelope"></i> Akun
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama Anda" required>
                        </div>

                        {{-- Input password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required>
                        </div>

                        {{-- Checkbox "Ingat saya" -> dikirim sebagai 'remember' --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        {{-- Tombol submit login --}}
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </form>

                    <hr class="my-4">

                    {{-- Tautan pendaftaran (belum tersedia fungsinya) --}}
                    <p class="text-center text-muted">
                        Belum punya akun? <a href="#" class="text-primary">Daftar di sini</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
