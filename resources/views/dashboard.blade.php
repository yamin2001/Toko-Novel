@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center">
        <h2 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}</h2>
        <p class="text-muted">Status Akun: <strong>{{ strtoupper(Auth::user()->role) }}</strong></p>
        
        <div class="mt-5">
            @if(Auth::user()->role == 'admin')
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4">
                            <h5>Manajemen Buku</h5>
                            <a href="{{ route('admin.index') }}" class="btn btn-dark mt-3">Buka Dashboard Admin</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4">
                            <h5>Cari Novel Favorit</h5>
                            <a href="{{ route('pelanggan.index') }}" class="btn btn-primary mt-3">Lihat Katalog</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection