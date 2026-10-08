@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📦 Pesanan Saya</h3>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
           <table class="table table-hover align-middle bg-white shadow-sm rounded-3 overflow-hidden">
    <thead class="bg-primary text-white">
        <tr>
            <th class="py-3 px-4">Tanggal</th>
            <th>Novel yang Dipesan</th>
            <th class="text-center">Total Harga</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pesanan as $item)
        <tr>
            <td class="px-4 text-muted small">
                {{ $item->created_at->format('d M Y') }}<br>
                <span class="text-secondary">{{ $item->created_at->format('H:i') }} WIB</span>
            </td>
            <td>
                <ul class="list-unstyled mb-0">
                    @foreach($item->details as $detail)
                    <li class="mb-1">
                        <i class="fas fa-book-open text-primary me-2 small"></i>
                        <span class="fw-bold">{{ $detail->novel->judul ?? 'Novel Dihapus' }}</span> 
                        <span class="badge bg-light text-dark border ms-1">{{ $detail->jumlah }}x</span>
                    </li>
                    @endforeach
                </ul>
            </td>
            <td class="text-center fw-bold text-primary">
                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
            </td>
            <td class="text-center">
                @if($item->status == 'Menunggu')
                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">⏳ Menunggu</span>
                @elseif($item->status == 'Dikonfirmasi')
                    <span class="badge rounded-pill bg-info text-white px-3 py-2">✅ Dikonfirmasi</span>
                @elseif($item->status == 'Dikirim')
                    <span class="badge rounded-pill bg-primary text-white px-3 py-2">🚚 Dikirim</span>
                @elseif($item->status == 'Selesai')
                    <span class="badge rounded-pill bg-success text-white px-3 py-2">🏁 Selesai</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center py-5">
                <p class="text-muted mb-0">Belum ada riwayat pesanan, Bos.</p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
        </div>
    </div>
</div>
@endsection