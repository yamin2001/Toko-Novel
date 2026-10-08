@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h4 class="fw-bold mb-4">🛒 Keranjang Belanja Anda</h4>
            
            {{-- Daftar Item Novel --}}
            @forelse($cartItems as $item)
            <div class="card shadow-sm border-0 mb-3 rounded-3 overflow-hidden">
                <div class="card-body p-3">
                    <div class="row align-items-center text-center text-md-start">
                        <div class="col-md-2 mb-3 mb-md-0">
                            <img src="{{ asset('storage/' . $item->novel->gambar) }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 120px; object-fit: cover;">
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <h5 class="fw-bold mb-1">{{ $item->novel->judul }}</h5>
                            <p class="text-success fw-bold mb-0">Rp {{ number_format($item->novel->harga, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label class="small text-muted d-block mb-1">Jumlah</label>
                            <div class="d-inline-flex align-items-center px-3 py-1 bg-light rounded-pill border">
                                <span class="fw-bold">{{ $item->jumlah }} Novel</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-md-end">
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill border-0">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                <div class="card-body">
                    <h2 class="display-1 text-muted opacity-25 mb-3">🛒</h2>
                    <h5 class="text-muted">Wah, keranjangmu masih kosong nih...</h5>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-primary mt-3 px-4 rounded-pill">Ayo Cari Novel Seru!</a>
                </div>
            </div>
            @endforelse
            @if($cartItems->count() > 0)
            <div class="card border-0 shadow-lg mt-5 rounded-4 overflow-hidden" 
                 style="background: linear-gradient(135deg, #f8fbff 0%, #e3f2fd 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h5 class="fw-bold mb-1">Total Pembayaran</h5>
                            <p class="text-muted small mb-0">Total pembayaran yang harus dibayar.</p>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0 text-md-center">
                            <p class="text-muted small mb-0">Total Item ({{ $cartItems->sum('jumlah') }} Novel)</p>
                            <h3 class="text-success fw-bold mb-0">Rp {{ number_format($totalHarga, 0, ',', '.') }}</h3>
                        </div>
                        <div class="col-md-3 text-md-end">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 fw-bold rounded-pill shadow-sm py-3">
                                Lanjut Checkout →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection