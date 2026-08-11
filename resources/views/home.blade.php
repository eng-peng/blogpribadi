{{-- ==================================================================
     File: resources/views/home.blade.php
     Fungsi: Halaman beranda publik yang menampilkan daftar artikel.
     Data $posts dikirim dari HomeController@index.
     ================================================================== --}}

{{-- Gunakan layout utama 'layouts.app' --}}
@extends('layouts.app')

{{-- Isi judul halaman (di tab browser) --}}
@section('title', 'Blog Terbaru')

{{-- Blok konten utama yang dimasukkan ke @yield('content') di layout --}}
@section('content')
<div class="container py-5">

    {{-- Header beranda --}}
    <div class="row mb-5">
        <div class="col-md-12">
            <h1 class="display-4 text-gradient mb-2">
                <i class="fas fa-newspaper"></i> Blog Terbaru
            </h1>
            <p class="text-muted fs-5">Temukan artikel dan cerita menarik dari penulis kami</p>
        </div>
    </div>

    <div class="row">

        {{-- @forelse: loop daftar artikel; @empty dijalankan jika list kosong --}}
        @forelse($posts as $post)
        <div class="col-lg-4 col-md-6 mb-4">

            {{-- Kartu untuk satu artikel --}}
            <div class="card h-100">

                <div class="card-body d-flex flex-column">

                    {{-- Badge nama kategori ($post->category?->name).
                         Operator '?->' aman jika kategori null -> fallback 'Tanpa Kategori' --}}
                    <span class="badge bg-primary mb-3" style="width: fit-content;">
                        <i class="fas fa-tag"></i> {{ $post->category?->name ?? 'Tanpa Kategori' }}
                    </span>

                    {{-- Judul artikel, dipotong maksimal 50 karakter --}}
                    <h5 class="card-title mb-3">
                        {{ \Illuminate\Support\Str::limit($post->title, 50) }}
                    </h5>

                    {{-- Tanggal publikasi artikel, diformat 'd M Y' --}}
                    <small class="text-muted mb-3">
                        <i class="far fa-calendar"></i> {{ $post->created_at?->format('d M Y') }}
                    </small>

                    {{-- Ringkasan isi artikel: tag HTML dihapus (strip_tags),
                         lalu dipotong maksimal 100 karakter --}}
                    <p class="card-text flex-grow-1">
                        {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}...
                    </p>

                    {{-- Tombol menuju halaman detail artikel --}}
                    <a href="{{ route('post.show', $post->id) }}"
                       class="btn btn-primary mt-auto">

                        <i class="fas fa-arrow-right"></i> Baca Selengkapnya

                    </a>

                </div>

            </div>

        </div>

        {{-- Jika tidak ada artikel sama sekali, tampilkan pesan ini --}}
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Belum ada artikel.
            </div>
        </div>
        @endforelse

    </div>
</div>
@endsection
