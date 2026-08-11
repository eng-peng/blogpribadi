{{-- ==================================================================
     File: resources/views/admin/posts/create.blade.php
     Fungsi: Form untuk membuat artikel baru (admin).
     Data $categories dikirim dari PostController@create.
     ================================================================== --}}

{{-- Gunakan layout utama 'layouts.app' --}}
@extends('layouts.app')

{{-- Judul tab browser --}}
@section('title', 'Tambah Artikel')

{{-- Blok konten utama --}}
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Tambah Artikel</h1>

    <div class="card">
        <div class="card-body p-4">

            {{-- Form dikirim via POST ke rute store artikel --}}
            <form action="{{ route('admin.posts.store') }}" method="POST">

                {{-- @csrf: token keamanan wajib untuk form POST --}}
                @csrf

                {{-- Input judul artikel. @error menampilkan error validasi
                     dan menandai field dengan class is-invalid --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dropdown pilihan kategori (opsional) --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        {{-- Opsi kosong: berarti artikel tanpa kategori --}}
                        <option value="">-- Pilih Kategori --</option>

                        {{-- Loop semua kategori. @selected menandai opsi yang
                             dipilih sebelumnya (saat validasi gagal) --}}
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Textarea isi artikel --}}
                <div class="mb-3">
                    <label for="content" class="form-label">Konten</label>
                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="8">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol simpan & kembali --}}
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>
</div>
@endsection
