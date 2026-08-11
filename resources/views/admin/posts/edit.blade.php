{{-- ==================================================================
     File: resources/views/admin/posts/edit.blade.php
     Fungsi: Form untuk mengedit artikel yang sudah ada (admin).
     Data $post & $categories dikirim dari PostController@edit.
     ================================================================== --}}

{{-- Gunakan layout utama 'layouts.app' --}}
@extends('layouts.app')

{{-- Judul tab browser --}}
@section('title', 'Edit Artikel')

{{-- Blok konten utama --}}
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Edit Artikel</h1>

    <div class="card">
        <div class="card-body p-4">

            {{-- Form dikirim via POST ke rute update artikel.
                 @method('PUT') memberitahu Laravel bahwa ini permintaan PUT --}}
            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">

                {{-- @csrf: token keamanan wajib untuk form POST --}}
                @csrf
                @method('PUT')

                {{-- Input judul, diisi nilai lama artikel (old() fallback ke $post->title) --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dropdown kategori, opsi yang sedang dipakai artikel ditandai @selected --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Textarea konten, diisi konten artikel yang lama --}}
                <div class="mb-3">
                    <label for="content" class="form-label">Konten</label>
                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="8">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol update & kembali --}}
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Artikel
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>
</div>
@endsection
