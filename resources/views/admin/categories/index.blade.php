{{-- ==================================================================
     File: resources/views/admin/categories/index.blade.php
     Fungsi: Halaman kelola kategori admin (daftar + tambah/edit via modal).
     Data $categories dikirim dari CategoryController@index.
     ================================================================== --}}

{{-- Gunakan layout utama 'layouts.app' --}}
@extends('layouts.app')

{{-- Judul tab browser --}}
@section('title', 'Kelola Kategori')

{{-- Blok konten utama --}}
@section('content')
<div class="container mt-5">

    {{-- Header halaman: judul + tombol Tambah & Kembali --}}
    <div class="row mb-3">
        <div class="col-md-8">
            <h1>Kelola Kategori</h1>
        </div>
        <div class="col-md-4 text-end">
            {{-- Tombol memunculkan modal tambah kategori (Bootstrap modal) --}}
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Tambah Kategori</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    {{-- Pesan sukses dari session (mis. "Kategori berhasil ditambahkan.") --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error dari session (mis. "Kategori sudah ada.") --}}
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Error validasi dari request (jika ada) --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
        </div>
    @endif

    {{-- Tabel daftar kategori --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="10%">No</th>
                    <th width="60%">Nama Kategori</th>
                    <th width="30%">Aksi</th>
                </tr>
            </thead>
            <tbody>

                {{-- Loop semua kategori; @empty jika belum ada data --}}
                @forelse($categories as $index => $category)
                    <tr>
                        {{-- Nomor urut dimulai dari 1 --}}
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>

                            {{-- Tombol Edit: membuka modal edit untuk kategori ini --}}
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">Edit</button>

                            {{-- Form hapus via DELETE (dengan konfirmasi browser) --}}
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>

                        </td>
                    </tr>

                    {{-- Modal Edit Kategori (muncul per baris, ID unik per kategori) --}}
                    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                {{-- Form update dikirim via PUT ke rute update kategori --}}
                                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            {{-- Input nama kategori dengan nilai lama terisi --}}
                                            <label for="edit_name{{ $category->id }}" class="form-label">Nama Kategori</label>
                                            <input type="text" class="form-control" id="edit_name{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                {{-- Jika belum ada kategori --}}
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada kategori.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah Kategori --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Form simpan kategori baru via POST ke rute store --}}
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
