@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold">📥 Data Pesanan Masuk</h2>
        <p class="text-muted">Daftar pelanggan yang sudah melakukan pemesanan novel dan mengurangi stok otomatis.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Nama Pemesan</th>
                        <th>Novel yang Dipesan</th> {{-- Kolom Baru --}}
                        <th>Alamat Pengiriman</th>
                        <th>Nomor HP</th>
                        <th>Tanggal Pesan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $p)
                    <tr>
                        <td class="ps-3 fw-bold">{{ $p->nama }}</td>
                        <td>
                            {{-- Memanggil relasi novel dari model Pelanggan --}}
                            <span class="badge bg-info text-dark shadow-sm">
                                📖 {{ $p->novel->judul ?? 'Novel Terhapus' }}
                            </span>
                        </td>
                        <td>{{ $p->alamat }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $p->nomor_hp }}</span></td>
                        <td>{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td class="text-center">
                            {{-- FORM HAPUS --}}
                            <form action="{{ route('admin.pelanggan.destroy', $p->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tandai pesanan ini selesai?')">
                                    Selesai / Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada pesanan yang masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('admin.index') }}" class="btn btn-secondary shadow-sm">← Kembali ke Dashboard</a>
    </div>
</div>
@endsection