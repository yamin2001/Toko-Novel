@extends('layouts.app')

@section('content')
<div class="container py-5"> {{-- Padding Y-5 agar ada jarak dari navbar --}}
    
    {{-- HEADER JUDUL --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">🕹️ Data Pesanan Masuk</h3>
            <p class="text-muted small mb-0">Kelola konfirmasi pembayaran pelanggan di sini.</p>
        </div>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- TABEL DATA --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 px-4 text-secondary small text-uppercase">Informasi Pemesan</th>
                        <th class="py-3 text-secondary small text-uppercase" style="width: 30%;">Daftar Novel</th>
                        <th class="py-3 text-center text-secondary small text-uppercase">Total</th>
                        <th class="py-3 text-center text-secondary small text-uppercase">Bukti</th>
                       <th class="py-3 text-center text-secondary small text-uppercase" style="width: 220px;">Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $item)
                    <tr>
                        {{-- KOLOM 1: INFO PEMESAN --}}
                        <td class="px-4">
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-dark">{{ $item->nama_penerima }}</span>
                                <span class="text-muted small"><i class="fas fa-phone-alt me-1"></i> {{ $item->nomor_hp }}</span>
                                <small class="text-muted text-wrap mt-1" style="max-width: 200px; line-height: 1.2;">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $item->alamat_pengiriman }}
                                </small>
                            </div>
                        </td>

                        {{-- KOLOM 2: DAFTAR NOVEL --}}
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach($item->details as $detail)
                                    <li class="small text-dark mb-1">
                                        <i class="fas fa-book me-2 text-primary"></i> 
                                        {{ $detail->novel->judul ?? 'Novel Dihapus' }} 
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill ms-1">{{ $detail->jumlah }}x</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        {{-- KOLOM 3: TOTAL HARGA --}}
                        <td class="text-center">
                            <span class="fw-bold text-primary">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                        </td>

                        {{-- KOLOM 4: BUKTI BAYAR --}}
                        <td class="text-center">
                            @if($item->bukti_transfer)
                                <a href="{{ asset('storage/bukti_bayar/' . $item->bukti_transfer) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> Cek
                                </a>
                            @else
                                <span class="badge bg-danger-subtle text-danger p-2">Belum Bayar</span>
                            @endif
                        </td>

                        {{-- KOLOM 5: AKSI --}}
                        <td class="text-center">
                            <div class="d-flex flex-column gap-2 align-items-center">
                                {{-- Form Update Status --}}
                                <form action="{{ route('admin.pelanggan.konfirmasi', $item->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <select name="status" class="form-select border-primary-subtle text-center" style="font-size: 0.8rem;">
                                            <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                                            <option value="Dikonfirmasi" {{ $item->status == 'Dikonfirmasi' ? 'selected' : '' }}>✅ Konfirmasi</option>
                                            <option value="Dikirim" {{ $item->status == 'Dikirim' ? 'selected' : '' }}>🚚 Dikirim</option>
                                            <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>🏁 Selesai</option>
                                        </select>
                                       <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">
                                        <i class="fas fa-sync-alt me-1"></i> Update Pesanan
                                         </button>
                                    </div>
                                </form>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.pelanggan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger btn-sm text-decoration-none p-0" style="font-size: 0.8rem;">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="Kosong" style="width: 80px; opacity: 0.5;" class="mb-3">
                            <p class="mb-0">Belum ada pesanan masuk, Bos.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection