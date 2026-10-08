<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
        <h2>Katalog Novel</h2>
        <a href="{{ route('admin.create') }}" class="btn btn-primary">Admin: Tambah Novel</a>
    </div>

    <div class="row">
        @foreach($novels as $novel)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="{{ $novel->gambar }}" class="card-img-top" alt="cover">
                <div class="card-body">
                    <h5 class="card-title">{{ $novel->judul }}</h5>
                    <p class="text-warning">⭐ {{ $novel->rating }}</p>
                    <p class="fw-bold text-success">Rp {{ number_format($novel->harga) }}</p>
                    <p class="small text-muted">Stok: {{ $novel->stok }}</p>
                    <a href="{{ route('novels.show', $novel->id) }}" class="btn btn-outline-dark w-100">Detail & Beli</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>