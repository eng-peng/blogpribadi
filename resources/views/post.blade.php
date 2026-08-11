{{-- ==================================================================
     File: resources/views/post.blade.php
     Fungsi: Halaman detail satu artikel (publik).
     Data $post dikirim dari HomeController@show.
     ================================================================== --}}

{{-- Gunakan layout utama 'layouts.app' --}}
@extends('layouts.app')

{{-- Judul tab browser = judul artikel --}}
@section('title', $post->title)

{{-- Blok konten utama --}}
@section('content')
<div class="row justify-content-center py-5">

    <div class="col-md-8">

        {{-- Badge nama kategori (fallback jika tidak punya kategori) --}}
        <span class="badge bg-dark mb-3">
            <i class="fas fa-tag"></i> {{ $post->category?->name ?? 'Tanpa Kategori' }}
        </span>

        {{-- Judul artikel lengkap --}}
        <h1>
            {{ $post->title }}
        </h1>

        {{-- Tanggal & jam publikasi artikel --}}
        <small class="text-muted">
            <i class="far fa-calendar"></i> {{ $post->created_at?->format('d M Y H:i') }}
        </small>

        <hr>

        {{-- Isi artikel.
             - e()     = escape HTML untuk keamanan (cegah XSS)
             - nl2br() = ubah baris baru menjadi tag <br> (Blade/HTML) --}}
        <p style="line-height: 30px;">
            {!! nl2br(e($post->content)) !!}
        </p>

        {{-- Tombol kembali ke beranda --}}
        <a href="{{ route('home') }}"
           class="btn btn-secondary mt-3">

            <i class="fas fa-arrow-left"></i> Kembali

        </a>

    </div>

</div>
@endsection
