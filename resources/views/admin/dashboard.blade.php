{{-- ==================================================================
     File: resources/views/admin/dashboard.blade.php
     Fungsi: Halaman dashboard admin.
     Data $postsCount & $categoriesCount dikirim dari DashboardController@index.
     ================================================================== --}}

{{-- Gunakan layout utama 'layouts.app' --}}
@extends('layouts.app')

{{-- Judul tab browser --}}
@section('title', 'Dashboard Admin')

{{-- Blok konten utama --}}
@section('content')
<div class="container py-5">

    {{-- Header halaman + sapaan ke pengguna yang sedang login --}}
    <div class="row mb-5">
        <div class="col-md-12">
            <h1 class="display-5 text-gradient mb-2">
                <i class="fas fa-tachometer-alt"></i> Dashboard Admin
            </h1>
            {{-- auth()->user()->name = nama pengguna yang sedang login --}}
            <p class="text-muted">
                Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong> &#128075;
            </p>
        </div>
    </div>

    {{-- Kartu statistik jumlah artikel & kategori --}}
    <div class="row mb-5">

        {{-- Kartu Total Artikel --}}
        <div class="col-lg-6 mb-4">
            <div class="card text-white" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-uppercase opacity-75 mb-2">Total Artikel</h6>
                            {{-- Jumlah artikel dari $postsCount --}}
                            <h2 class="mb-0">{{ $postsCount }}</h2>
                        </div>
                        <i class="fas fa-newspaper fa-3x opacity-25"></i>
                    </div>
                    {{-- Tombol pintasan ke halaman kelola artikel --}}
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-light btn-sm mt-3">
                        <i class="fas fa-arrow-right"></i> Kelola Artikel
                    </a>
                </div>
            </div>
        </div>

        {{-- Kartu Total Kategori --}}
        <div class="col-lg-6 mb-4">
            <div class="card text-white" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-uppercase opacity-75 mb-2">Total Kategori</h6>
                            {{-- Jumlah kategori dari $categoriesCount --}}
                            <h2 class="mb-0">{{ $categoriesCount }}</h2>
                        </div>
                        <i class="fas fa-folder fa-3x opacity-25"></i>
                    </div>
                    {{-- Tombol pintasan ke halaman kelola kategori --}}
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-sm mt-3">
                        <i class="fas fa-arrow-right"></i> Kelola Kategori
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Menu cepat akses ke halaman-halaman admin --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Menu Cepat</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">

                        {{-- Tombol ke daftar artikel --}}
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-list fa-lg"></i><br>
                                <small>Daftar Artikel</small>
                            </a>
                        </div>

                        {{-- Tombol ke daftar kategori --}}
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-list fa-lg"></i><br>
                                <small>Daftar Kategori</small>
                            </a>
                        </div>

                        {{-- Tombol ke form buat artikel baru --}}
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-info w-100 py-3">
                                <i class="fas fa-plus fa-lg"></i><br>
                                <small>Artikel Baru</small>
                            </a>
                        </div>

                        {{-- Form logout langsung dari dashboard --}}
                        <div class="col-md-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 py-3">
                                    <i class="fas fa-sign-out-alt fa-lg"></i><br>
                                    <small>Logout</small>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
