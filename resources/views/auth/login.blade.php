<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiNovel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* 1. BACKGROUND GRADASI BIAR BEDA DARI TEMAN */
        body { 
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%); 
            font-family: 'Segoe UI', sans-serif; 
            height: 100vh;
            margin: 0;
        }

        .login-container { 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }

        /* 2. CARD LOGIN MEWAH */
        .login-card { 
            width: 100%; 
            max-width: 420px; 
            padding: 40px; 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
            border: none;
        }

        h3 {
            color: #1e3c72;
            font-weight: 700;
        }

        /* 3. INPUT FIELD STYLE */
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #dee2e6;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: #20c997;
            box-shadow: 0 0 0 0.25rem rgba(32, 201, 151, 0.25);
        }

        /* 4. TOMBOL GRADASI OCEANIC GLOW */
        .btn-login { 
            background: linear-gradient(135deg, #1e3c72 0%, #20c997 100%); 
            color: white; 
            border-radius: 10px; 
            padding: 12px; 
            font-weight: bold; 
            width: 100%; 
            border: none;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(32, 201, 151, 0.3);
        }

        .btn-login:hover { 
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(32, 201, 151, 0.5);
            color: white;
        }

        /* 5. LINK DAFTAR */
        .link-teal {
            color: #20c997 !important;
            font-weight: 600;
        }

        .link-teal:hover {
            color: #198754 !important;
            text-decoration: underline !important;
        }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="login-card">
        <div class="text-center mb-4">
            <h3 class="mb-1">Masuk ke SiNovel</h3>
            <p class="text-muted small">Silakan masuk untuk mulai belanja novel</p>
        </div>

        {{-- Notifikasi Jika Error --}}
        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 10px;">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label small fw-bold">Alamat Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-login shadow">
                <i class="fas fa-sign-in-alt me-2"></i> Masuk Sekarang
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="small text-muted mb-1">Belum punya akun? <a href="{{ route('register') }}" class="link-teal text-decoration-none">Daftar di sini</a></p>
            <a href="{{ url('/') }}" class="text-muted small text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda</a>
        </div>
    </div>
</div>

</body>
</html>