@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Dashboard Admin</h2>
        <div>
            <a href="{{ route('admin.create') }}" class="btn btn-primary shadow-sm">+ Tambah Novel</a>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-info text-white shadow-sm ms-2">Data Pesanan Masuk</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0"> {{-- p-0 biar tabel mepet rapi --}}
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3" width="10%">Cover</th>
                        <th>Info Novel</th> {{-- Gabungan Judul & Sinopsis --}}
                        <th>Harga</th>
                        <th>Status</th> {{-- Gabungan Rating & Stok --}}
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($novels as $novel)
                    <tr>
                        <td class="ps-3">
                            <img src="{{ asset('storage/' . $novel->gambar) }}" class="rounded shadow-sm" width="70" height="90" style="object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold text-primary">{{ $novel->judul }}</div>
                            <small class="text-muted d-block" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $novel->sinopsis }}
                            </small>
                        </td>
                        <td class="fw-bold">Rp {{ number_format($novel->harga, 0, ',', '.') }}</td>
                        <td>
                            <div class="badge bg-warning text-dark mb-1">⭐ {{ $novel->rating }}</div>
                            <div class="d-block small text-muted">Stok: {{ $novel->stok }}</div>
                        </td>
                        <td class="text-center pe-3">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('admin.edit', $novel->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.destroy', $novel->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data novel.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection