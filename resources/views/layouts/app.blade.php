<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SiNovel Store</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* 1. DASAR BODY */
        body { 
            background-color: #f0f4f8 !important; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #334155;
            margin: 0;
            padding: 0;
        }

        /* 2. NAVBAR GRADASI (Oceanic Glow) */
        .navbar { 
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #20c997 100%) !important;
            padding: 12px 0 !important;
            border-bottom: 3px solid #198754;
        }

        .navbar-brand {
            font-size: 1.5rem;
            letter-spacing: 1px;
        }

        .nav-link { 
            color: rgba(255,255,255,0.85) !important; 
            font-weight: 500;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover { 
            color: #ffffff !important; 
            transform: translateY(-1px);
        }

        .active-admin { 
            color: #ffffff !important; 
            font-weight: bold !important;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
        }

        /* 3. TOMBOL GRADASI (Global) */
        .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #20c997 100%) !important;
            border: none !important;
            font-weight: 600 !important;
            transition: 0.3s !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 15px rgba(32, 201, 151, 0.4) !important;
        }

        /* 4. KARTU (CARD) - Bikin Efek Melayang */
        .card {
            border: none !important;
            border-radius: 15px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        }

        .card:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        /* 5. FIX WARNA KARTU LAPORAN */
        .bg-primary { background: linear-gradient(45deg, #0d6efd, #0099ff) !important; }
        .bg-success { background: linear-gradient(45deg, #198754, #20c997) !important; }
        .bg-dark { background: linear-gradient(45deg, #1e293b, #334155) !important; }

        /* 6. DROPDOWN STYLE */
        .dropdown-menu {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
            margin-top: 10px !important;
        }

        .dropdown-item {
            padding: 10px 20px !important;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9 !important;
            color: #1e3c72 !important;
        }
    </style>
</head>
<body>
    <div id="app">
        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <i class="fas fa-book-open me-2"></i>SiNovel
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    {{-- MENU KIRI --}}
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if(strtolower(Auth::user()->role) === 'admin')
                                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.index') ? 'active-admin' : '' }}" href="{{ route('admin.index') }}">⚙️ Dashboard</a></li>
                                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.pelanggan.index') ? 'active-admin' : '' }}" href="{{ route('admin.pelanggan.index') }}">🛒 Pesanan</a></li>
                                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.laporan') ? 'active-admin' : '' }}" href="{{ route('admin.laporan') }}">📊 Laporan</a></li>
                            @else
                                <li class="nav-item"><a class="nav-link" href="{{ route('pelanggan.index') }}">📚 Katalog</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('pesanan.saya') }}">📦 Pesanan Saya</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">🛒 Keranjang</a></li>
                            @endif
                        @endauth
                    </ul>

                    {{-- MENU KANAN (USER) --}}
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fw-bold text-white bg-white bg-opacity-10 rounded-pill px-3" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow">
                                    <a class="dropdown-item text-danger fw-bold" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- KONTEN UTAMA --}}
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>