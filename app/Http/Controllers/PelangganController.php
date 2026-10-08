<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\Pelanggan;
use App\Models\Transaksi; // WAJIB: Agar baris 62 tidak error
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // WAJIB: Agar Auth::id() dikenali

class PelangganController extends Controller
{
    public function index() {
        $novels = Novel::latest()->get();
        return view('pelanggan.index', compact('novels'));
    }

    public function show($id) {
        $novel = Novel::findOrFail($id);
        return view('pelanggan.show', compact('novel'));
    }

    public function formPesan($id) {
        $novel = Novel::findOrFail($id);
        
        if ($novel->stok <= 0) {
            return back()->with('error', 'Maaf, stok novel ini sedang habis.');
        }
        
        return view('pelanggan.pesan', compact('novel'));
    }

    public function prosesPesan(Request $request, $id) {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'nomor_hp' => 'required',
        ]);

        $novel = Novel::findOrFail($id);

        if ($novel->stok <= 0) {
            return redirect()->route('pelanggan.index')->with('error', 'Gagal memesan, stok habis!');
        }
 
        Pelanggan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nomor_hp' => $request->nomor_hp,
            'novel_id' => $id, 
        ]);

        $novel->decrement('stok'); 

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pesanan berhasil!. ' . $novel->judul . ' Penjual akan segera menghubungi Anda.');
    }

    public function pesananSaya()
    {
        // Baris ini sekarang aman karena Transaksi & Auth sudah di-import di atas
        $pesanan = Transaksi::where('user_id', Auth::id())->latest()->get(); 
        return view('pelanggan.pesanan_saya', compact('pesanan'));
    }

    // Fungsi untuk Admin melihat pesanan
    public function adminIndex() {
        $pelanggans = Pelanggan::with('novel')->latest()->get();
        return view('admin.pelanggan', compact('pelanggans'));
    }

    // Fungsi untuk Admin menghapus pesanan
    public function destroy($id) {
        Pelanggan::findOrFail($id)->delete();
        return back()->with('success', 'Data pesanan berhasil dihapus');
    }
}