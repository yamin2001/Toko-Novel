<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - SiNovel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Figtree', sans-serif; margin: 0; background: #f8fafc; }
        .hero { height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; position: relative; }
        h1 { font-size: 3.5rem; font-weight: 800; color: #1a202c; }
        .btn-custom { 
            padding: 15px 45px; background: #4a90e2; color: white; 
            text-decoration: none; border-radius: 50px; font-weight: bold;
            position: relative; z-index: 9999;
        }
    </style>
</head>
<body>
    <div class="hero">
        <h1>Temukan Dunia Dalam Buku</h1>
        <p>Koleksi novel terlengkap untuk menemani waktu luangmu.</p>
        
        @auth
            <a href="{{ route('pelanggan.index') }}" class="btn-custom">Mulai Cari Novel Yuk!!</a>
        @else
            <a href="{{ route('login') }}" class="btn-custom">Mulai Cari Novel Yuk!!</a>
        @endauth
    </div>
</body>
</html>