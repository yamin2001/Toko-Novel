@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm p-4">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $novel->gambar) }}" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-md-8">
                        <h2 class="fw-bold">{{ $novel->judul }}</h2>

                            <h3 class="text-success fw-bold">Rp {{ number_format($novel->harga, 0, ',', '.') }}</h3>
                        <div class="d-inline-block bg-light border rounded-pill px-3 py-1 mb-3 shadow-sm">
                                <span class="text-warning">★</span> 
                                <span class="fw-bold">{{ $novel->rating }}</span>
                                <small class="text-muted">/ 5.0</small>
                            </div>
                            <hr>

                        <h5><strong>Sinopsis:</strong></h5>
                        <p class="text-muted">{{ $novel->sinopsis }}</p>
                            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary px-4">Kembali</a>
                           <form action="{{ route('cart.add', $novel->id) }}" method="POST">
                     @csrf
                     <div class="input-group mb-3" style="width: 150px;">
                            <span class="input-group-text">Jumlah</span>
                            <input type="number" name="jumlah" class="form-control" value="1" min="1" max="{{ $novel->stok }}">
                        </div>
                        <button type="submit" class="btn btn-success fw-bold py-2 px-4">
                            + Masukkan Keranjang
                        </button>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection