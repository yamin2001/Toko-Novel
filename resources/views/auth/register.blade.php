@extends('layouts.app')

@section('content')
<style>
    /* Bikin card lebih estetik dan melayang */
    .register-card {
        border-radius: 20px !important;
        overflow: hidden;
        border: none !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;
    }

    /* Header gradasi oceanic */
    .register-header {
        background: linear-gradient(135deg, #1e3c72 0%, #20c997 100%) !important;
        color: white;
        padding: 25px !important;
        border: none !important;
    }

    /* Input box modern */
    .form-control {
        border-radius: 10px !important;
        padding: 10px 15px !important;
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
    }

    .form-control:focus {
        border-color: #20c997 !important;
        box-shadow: 0 0 0 0.25rem rgba(32, 201, 151, 0.15) !important;
    }

    /* Tombol gradasi */
    .btn-register {
        background: linear-gradient(135deg, #1e3c72 0%, #20c997 100%) !important;
        border: none !important;
        color: white !important;
        font-weight: bold !important;
        border-radius: 10px !important;
        transition: 0.3s !important;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(32, 201, 151, 0.4) !important;
    }

    .link-login {
        color: #20c997 !important;
        font-weight: bold;
        text-decoration: none;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card register-card">
                <div class="card-header register-header text-center">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-user-plus me-2"></i>Daftar Akun Baru</h4>
                    <small class="opacity-75">Gabung sekarang di SiNovel Store</small>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Alamat Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label small fw-bold text-secondary">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register w-100 py-3 shadow-sm">
                            <i class="fas fa-check-circle me-2"></i>Daftarkan Akun
                        </button>
                    </form>
                </div>

                <div class="card-footer bg-light border-0 text-center py-4">
                    <p class="mb-0 small text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="link-login">Login di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection