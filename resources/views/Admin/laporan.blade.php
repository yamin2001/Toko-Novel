@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    {{-- JUDUL HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary">📊 Laporan Keuangan</h3>
            <p class="text-muted small mb-0">Pantau pendapatan toko secara real-time.</p>
        </div>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    {{-- KARTU STATISTIK --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden" 
                 style="background: linear-gradient(45deg, #0d6efd, #0099ff) !important;">
                <div class="card-body text-center py-4">
                    <i class="fas fa-calendar-week position-absolute start-0 bottom-0 opacity-25" style="font-size: 5rem; margin-left: -10px; margin-bottom: -10px;"></i>
                    <h6 class="text-white-50 text-uppercase tracking-wide mb-2 small fw-bold">Minggu Ini</h6>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($mingguan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden"
                 style="background: linear-gradient(45deg, #198754, #20c997) !important;">
                <div class="card-body text-center py-4">
                    <i class="fas fa-calendar-alt position-absolute start-0 bottom-0 opacity-25" style="font-size: 5rem; margin-left: -10px; margin-bottom: -10px;"></i>
                    <h6 class="text-white-50 text-uppercase tracking-wide mb-2 small fw-bold">Bulan Ini</h6>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($bulanan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden"
                 style="background: linear-gradient(45deg, #1e293b, #334155) !important;">
                <div class="card-body text-center py-4">
                    <i class="fas fa-chart-line position-absolute start-0 bottom-0 opacity-25" style="font-size: 5rem; margin-left: -10px; margin-bottom: -10px;"></i>
                    <h6 class="text-white-50 text-uppercase tracking-wide mb-2 small fw-bold">Tahun Ini</h6>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($tahunan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER DATA --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-filter me-2 text-primary"></i>Filter Laporan</h6>
            <form action="{{ route('admin.laporan') }}" method="GET">
                <div class="row g-3 align-items-end">
                    
                    {{-- OPSI 1: TANGGAL AWAL & AKHIR --}}
                    <div class="col-md-3">
                        <label class="fw-bold small mb-1 text-muted">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control rounded-3 bg-light border-0">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold small mb-1 text-muted">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control rounded-3 bg-light border-0">
                    </div>
                    
                    {{-- OPSI 2: Tahun --}}

                    <div class="col-md-2">
                        <label class="fw-bold small mb-1 text-muted">Tahun</label>
                        <div class="input-group">
                            <select name="tahun" class="form-select rounded-3 bg-light border-0">
                                <option value="">- Semua -</option>
                                @php $tahunSekarang = date('Y'); @endphp
                                @foreach(range($tahunSekarang, $tahunSekarang - 2) as $t)
                                    <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary rounded-3 ms-2 shadow-sm">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                </div>

                {{-- TOMBOL RESET --}}
                @if(request('tanggal_awal') || request('bulan') || request('tahun'))
                <div class="mt-3 text-end border-top pt-3">
                    <a href="{{ route('admin.laporan') }}" class="btn btn-sm btn-outline-danger rounded-pill px-4 fw-bold">
                        <i class="fas fa-sync-alt me-1"></i> Reset Filter
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0 border-bottom">
            <h5 class="fw-bold mb-0 text-dark">📋 Riwayat Transaksi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="py-3 ps-4">Tanggal</th>
                            <th class="py-3">Nama Pemesan</th>
                            <th class="py-3">Item Terjual</th>
                            <th class="py-3 text-end pe-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiSukses as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $item->created_at->format('d M Y') }}</span>
                                    <span class="text-muted small">{{ $item->created_at->format('H:i') }} WIB</span>
                                </div>
                            </td>
                            <td class="fw-bold text-dark">{{ $item->nama_penerima }}</td>
                            <td>
                                @foreach($item->details as $detail)
                                    <div class="small text-muted">
                                        <i class="fas fa-book-open text-primary me-1"></i>
                                        {{ $detail->novel->judul ?? 'Novel Dihapus' }} <span class="fw-bold">x{{ $detail->jumlah }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td class="text-end pe-4 text-success fw-bold">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-search mb-3 d-block display-4 opacity-25"></i>
                                <p class="mb-0">Tidak ada data untuk filter ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($transaksiSukses->count() > 0)
        <div class="card-footer bg-light border-0 py-3 text-end pe-4">
            <span class="text-muted me-2">Total Pendapatan Terfilter:</span>
            <span class="fw-bold text-primary fs-5">Rp {{ number_format($transaksiSukses->sum('total_harga'), 0, ',', '.') }}</span>
        </div>
        @endif
    </div>
</div>
@endsection