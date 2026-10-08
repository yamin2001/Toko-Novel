@extends('layouts.app')

@section('content')
<style>
    /* Agar gambar buku seragam & rapi */
    .book-cover {
        height: 350px;
        object-fit: cover;
        width: 100%;
    }
    .card-novel {
        transition: transform 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    .card-novel:hover {
        transform: translateY(-10px);
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold"><span class="me-2">📚</span> Katalog SiNovel</h2>
    </div>

    <div class="row g-4">
        {{-- Loop menggunakan $novels sesuai Controller --}}
        @foreach($novels as $novel)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-novel shadow-sm h-100 bg-light">
                <img src="{{ asset('storage/' . $novel->gambar) }}" class="card-img-top book-cover" alt="{{ $novel->judul }}">
                
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-1">{{ $novel->judul }}</h6>
                        <p class="text-success fw-bold mb-3 small">Rp {{ number_format($novel->harga, 0, ',', '.') }}</p>
                    </div>
                    
                    <a href="{{ route('pelanggan.show', $novel->id) }}" class="btn btn-primary rounded-pill w-100 shadow-sm">
                        Lihat Detail
                    </a>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                    // Cek apakah ada session sukses dari Controller
                    @if(session('success'))
                        Swal.fire({
                            title: "Berhasil!",
                            text: "{{ session('success') }}",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 3000, // Hilang otomatis dalam 3 detik
                            background: '#ffffff',
                            customClass: {
                                title: 'fw-bold text-dark',
                                popup: 'rounded-4'
                            }
                        });
                    @endif

                    // Cek jika ada error
                    @if(session('error'))
                        Swal.fire({
                            icon: "error",
                            title: "Waduh...",
                            text: "{{ session('error') }}",
                        });
                    @endif
                </script>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection