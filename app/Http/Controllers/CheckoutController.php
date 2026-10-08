<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller {
    
    public function index() {
        $cartItems = Keranjang::where('user_id', Auth::id())->get();
        $totalHarga = $cartItems->sum(fn($item) => $item->novel->harga * $item->jumlah);
        return view('pelanggan.checkout', compact('cartItems', 'totalHarga'));
    }

    public function proses(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama'           => 'required|string|max:255',
            'alamat'         => 'required|string',
            'hp'             => 'required|string|max:20',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required'           => 'Nama penerima wajib diisi!',
            'bukti_transfer.required' => 'Wajib upload bukti transfer!',
        ]);

        // 2. Ambil semua data keranjang
        $cartItems = Keranjang::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('pelanggan.index')->with('error', 'Keranjang kosong!');
        }

        // 3. Proses Upload Gambar (Simpan ke folder yang benar)
        $namaFile = null;
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            // Simpan ke public/storage/bukti_bayar agar tidak 404
            $file->move(public_path('storage/bukti_bayar'), $namaFile);
        }

        // 4. Hitung total harga semua item
        $totalSemua = $cartItems->sum(fn($item) => $item->novel->harga * $item->jumlah);

        // 5. Simpan ke tabel Transaksi (Header)
        $transaksi = Transaksi::create([
            'user_id'           => Auth::id(),
            'nama_penerima'     => $request->nama,   
            'alamat_pengiriman' => $request->alamat, 
            'nomor_hp'          => $request->hp,   
            'total_harga'       => $totalSemua,
            'bukti_transfer'    => $namaFile,
            'status'            => 'Menunggu', 
        ]);

        // 6. Simpan tiap item ke tabel DetailTransaksi (Looping)
        foreach ($cartItems as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'novel_id'     => $item->novel_id,
                'jumlah'       => $item->jumlah,
                'subtotal'     => $item->novel->harga * $item->jumlah,
            ]);
        }

        // 7. Hapus keranjang setelah sukses
        Keranjang::where('user_id', Auth::id())->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pesanan berhasil dikirim, Bos!');
    }
}