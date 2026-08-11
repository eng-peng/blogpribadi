{{-- ==================================================================
     File: resources/views/admin/posts/index.blade.php
     Fungsi: Halaman daftar/kelola artikel admin.
     Data $posts dikirim dari PostController@index.
     ================================================================== --}}

{{-- Gunakan layout utama 'layouts.app' --}}
@extends('layouts.app')

{{-- Judul tab browser --}}
@section('title', 'Kelola Artikel')

{{-- Blok konten utama --}}
@section('content')
<div class="container mt-5">

    {{-- Header halaman: judul + tombol Buat Artikel & Kembali --}}
    <div class="row mb-3">
        <div class="col-md-8">
            <h1>Kelola Artikel</h1>
        </div>
        <div class="col-md-4 text-end">
            {{-- Tombol menuju form tambah artikel baru --}}
            <a href="{{ route('admin.posts.create') }}" class="btn btn-success">+ Buat Artikel Baru</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    {{-- Pesan sukses dari session (mis. "Artikel berhasil ditambahkan.") --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Tabel daftar artikel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="40%">Judul</th>
                    <th width="25%">Kategori</th>
                    <th width="15%">Tanggal</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>

                {{-- Loop semua artikel; @empty jika belum ada data --}}
                @forelse($posts as $index => $post)
                    <tr>
                        {{-- Nomor urut dimulai dari 1 --}}
                        <td>{{ $index + 1 }}</td>

                        {{-- Judul artikel dipotong 50 karakter --}}
                        <td>{{ \Illuminate\Support\Str::limit($post->title, 50) }}...</td>

                        {{-- Nama kategori (fallback jika tidak ada kategori) --}}
                        <td><span class="badge bg-info">{{ $post->category?->name ?? 'Tanpa Kategori' }}</span></td>

                        {{-- Tanggal dibuat, format 'd-m-Y' --}}
                        <td>{{ $post->created_at?->format('d-m-Y') }}</td>

                        <td>
                            {{-- Tombol edit menuju form edit artikel --}}
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            {{-- Form hapus via DELETE dengan konfirmasi browser --}}
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>

                {{-- Jika belum ada artikel --}}
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada artikel.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
@endsection
