<!DOCTYPE html>
<html lang="id">
{{-- ==================================================================
     File: resources/views/layouts/app.blade.php
     Fungsi: Layout utama (master layout) untuk seluruh halaman.
     Semua view lain "meng-extends" file ini dan mengisi @section.
     ================================================================== --}}
<head>
    {{-- Meta dasar: encoding, kompatibilitas IE, dan viewport responsif --}}
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- @yield('title', 'BlogSpot'): judul tab browser, bisa di-override dari halaman anak.
         Jika halaman anak tidak set 'title', default 'BlogSpot' dipakai. --}}
    <title>@yield('title', 'BlogSpot') - Platform Blog Pribadi</title>

    {{-- Bootstrap CSS (framework styling) via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome (kumpulan ikon) via CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Kustom CSS global: variabel warna tema & penyesuaian komponen Bootstrap --}}
    <style>
        :root {
            /* Palet warna utama aplikasi */
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --dark-color: #1f2937;
            --light-color: #f3f4f6;
        }

        /* Reset margin/padding & gunakan border-box agar ukuran elemen konsisten */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Gaya dasar body: font, latar, warna teks, dan tata letak flex kolom
           agar footer selalu menempel di bawah */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            color: #374151;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        /* Area konten utama memakai sisa ruang vertikal */
        main {
            flex: 1;
        }

        /* Navbar: gradasi warna brand, bayangan, dan padding */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        /* Brand logo di navbar */
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        /* Link menu di navbar (warna semi-transparan) */
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        /* Link navbar saat hover jadi putih penuh */
        .nav-link:hover {
            color: white !important;
        }

        /* Kartu: tanpa border, sudut membulat, dan bayangan halus */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        /* Efek terangkat saat kartu di-hover */
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.12);
        }

        /* Header kartu bergradasi dengan teks putih */
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 12px 12px 0 0;
        }

        /* Tombol: sudut membulat, tanpa border bawaan */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        /* Tombol primer bergradasi sesuai tema */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        /* Hover tombol primer: balik arah gradasi + efek terangkat */
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        /* Tombol sukses (hijau) */
        .btn-success {
            background-color: #10b981;
        }

        .btn-success:hover {
            background-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        /* Tombol warning (kuning) dengan teks putih */
        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d97706;
            color: white;
            transform: translateY(-2px);
        }

        /* Tombol danger (merah) */
        .btn-danger {
            background-color: #ef4444;
        }

        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        /* Tabel: latar putih dan sudut membulat */
        .table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Header tabel bergradasi dengan teks putih */
        .table thead {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        /* Baris tabel diberi garis bawah */
        .table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease;
        }

        /* Baris tabel terhighlight saat hover */
        .table tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Badge (label kecil): padding & sudut membulat */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Input form: sudut membulat dengan border halus */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            padding: 0.75rem;
        }

        /* Input saat fokus: border berwarna tema + efek glow */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* Alert: tanpa border, sudut membulat */
        .alert {
            border-radius: 8px;
            border: none;
        }

        /* Alert sukses: latar hijau muda dengan teks hijau tua */
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        /* Alert danger: latar merah muda dengan teks merah tua */
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Modal: tanpa border, sudut besar, bayangan dalam */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        /* Header modal bergradasi dengan teks putih */
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
        }

        /* Footer halaman: latar gelap dengan teks putih */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 1px solid #374151;
        }

        /* Utility: teks gradasi (digunakan untuk judul halaman) */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Warna heading memakai warna gelap tema */
        h1, h2, h3, h4, h5, h6 {
            color: var(--dark-color);
            font-weight: 600;
        }

        /* Batasi lebar container maksimal 1200px */
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body>

{{-- NAVBAR: menu navigasi utama aplikasi --}}
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">

        {{-- Logo/brand mengarah ke beranda --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-blog"></i> BlogSpot
        </a>

        {{-- Tombol hamburger untuk menu saat layar kecil (mobile) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                {{-- Menu Beranda (publik) --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
                </li>

                {{-- @auth: blok ini hanya tampil jika pengguna sudah login --}}
                @auth
                    <li class="nav-item">
                        {{-- Menu Dashboard (hanya untuk yang sudah login) --}}
                        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        {{-- Form Logout via POST (butuh @csrf untuk keamanan) --}}
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link p-0 m-0 border-0 align-baseline" style="color: rgba(255,255,255,0.8) !important;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                {{-- @else: blok ini tampil jika pengguna BELUM login --}}
                @else
                    <li class="nav-item">
                        {{-- Menu Login untuk pengunjung --}}
                        <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

{{-- MAIN: area konten utama. @yield('content') akan diisi oleh
     blok @section('content') pada setiap halaman anak. --}}
<main>
    <div class="container mt-4">
        @yield('content')
    </div>
</main>

{{-- FOOTER: informasi situs, menu, dan kontak --}}
<footer class="mt-5 bg-blue text-white">
    <div class="container py-4">
        <div class="row">

            {{-- Kolom info brand --}}
            <div class="col-md-4 mb-4">
                <h5 style="color: #8b5cf6;"><i class="fas fa-blog"></i> BlogSpot</h5>
                <p class="text-white">Platform blog pribadi untuk berbagi cerita dan pengetahuan Anda.</p>
            </div>

            {{-- Kolom menu cepat --}}
            <div class="col-md-4 mb-4">
                <h5 style="color: #8b5cf6;">Menu</h5>
                <ul class="list-unstyled text-white">
                    <li><a href="{{ route('home') }}" class="text-white text-decoration-none">Beranda</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">Dashboard</a></li>
                </ul>
            </div>

            {{-- Kolom kontak --}}
            <div class="col-md-4 mb-4">
                <h5 style="color: #8b5cf6;">Kontak</h5>
                <p class="text-white">
                    <i class="fas fa-envelope"></i> info@blogspot.com<br>
                    <i class="fas fa-phone"></i> +62 121 219 6919
                </p>
            </div>

        </div>

        <hr class="my-3" style="border-color: #4b5563;">

        {{-- Copyright dengan tahun berjalan otomatis --}}
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="text-white mb-0">&copy; {{ date('Y') }} BlogSpot.</p>
            </div>
        </div>
    </div>
</footer>

{{-- Bootstrap JS (menangani dropdown, modal, dll.) via CDN --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
