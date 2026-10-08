@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-primary">📍 Pengiriman & Pembayaran</h4>
                        <p class="text-muted">Lengkapi data diri untuk menyelesaikan pesanan</p>
                    </div>

                    <form action="{{ route('checkout.proses') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="total" value="{{ $totalHarga }}">
                        
                        <div class="mb-3">
                            <label class="fw-bold mb-1">Nama Penerima</label>
                            <input type="text" name="nama" class="form-control rounded-3 py-2" placeholder="Nama lengkap Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control rounded-3" rows="3" placeholder="Contoh: Jl. Merdeka No. 10, Jakarta Pusat" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="fw-bold mb-1">Nomor HP (WhatsApp)</label>
                            <input type="text" name="hp" class="form-control rounded-3 py-2" placeholder="0812xxxx" required>
                        </div>
                        
                        <div class="p-3 mb-4 rounded-4" style="background-color: #f0f9ff; border: 1px solid #b6e0fe;">
                            <div class="row align-items-center">
                                <div class="col-sm-7">
                                    <p class="mb-1 small text-muted">Transfer ke Rekening:</p>
                                    <h6 class="fw-bold mb-0">Bank BRI 20012009</h6>
                                    <p class="fw-bold text-primary mb-2">a/n SiNovel Store</p>
                                    
                                    <hr class="my-2 opacity-10">
                                    
                                    <p class="mb-0 small text-muted">Total Pembayaran:</p>
                                    <h4 class="fw-bold text-success mb-0">Rp {{ number_format($totalHarga, 0, ',', '.') }}</h4>
                                </div>
                                
                                <div class="col-sm-5 text-center mt-3 mt-sm-0">
                                    <div class="bg-white p-2 d-inline-block rounded-3 shadow-sm">

                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=BCA-1234567-SiNovel" 
                                             alt="QR Code Pembayaran" 
                                             class="img-fluid" 
                                             style="width: 120px; height: 120px;">
                                    </div>
                                    <p class="mt-1 mb-0" style="font-size: 0.7rem; color: #666;">Scan untuk bayar cepat</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold mb-1 text-danger">📸 Upload Bukti Transfer</label>
                            <input type="file" name="bukti_transfer" class="form-control rounded-3" accept="image/*" required>
                            <small class="text-muted">Pastikan nominal dan nama pengirim terlihat jelas.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow">
                            Checkout Sekarang 🚀
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection