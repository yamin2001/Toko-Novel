<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use Carbon\Carbon;
use App\Models\Transaksi; 
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // 1. DASHBOARD ADMIN
    public function index() {
        $novels = Novel::latest()->get();
        return view('admin.index', compact('novels'));
    }

    // 2. CRUD NOVEL (TAMBAH)
    public function create() { 
        return view('admin.create'); 
    }

    public function store(Request $request) {
        $data = $request->validate([
            'judul'    => 'required',
            'harga'    => 'required|numeric',
            'stok'     => 'required|numeric',
            'rating'   => 'nullable|numeric',
            'sinopsis' => 'nullable',
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data['gambar'] = $request->file('gambar')->store('novels', 'public');
        Novel::create($data);

        return redirect()->route('admin.index')->with('success', 'Novel berhasil ditambah!');
    }

    // 3. CRUD NOVEL (EDIT)
    public function edit($id) {
        $novel = Novel::findOrFail($id);
        return view('admin.edit', compact('novel'));
    }

    public function update(Request $request, $id) {
        $novel = Novel::findOrFail($id);
        
        $data = $request->validate([
            'judul'    => 'required',
            'harga'    => 'required|numeric',
            'stok'     => 'required|numeric',
            'rating'   => 'nullable|numeric',
            'sinopsis' => 'nullable',
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if ($novel->gambar) Storage::disk('public')->delete($novel->gambar);
            $data['gambar'] = $request->file('gambar')->store('novels', 'public');
        }

        $novel->update($data);
        return redirect()->route('admin.index')->with('success', 'Novel berhasil diupdate!');
    }

    // 4. CRUD NOVEL (HAPUS)
    public function destroy($id) {
        $novel = Novel::findOrFail($id);
        if ($novel->gambar) Storage::disk('public')->delete($novel->gambar);
        $novel->delete();
        return back()->with('success', 'Novel berhasil dihapus');
    }

    // 5. MANAJEMEN PESANAN PELANGGAN
    public function pelangganIndex() {
        $pesanan = Transaksi::latest()->get();
        return view('admin.pesanan', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id) {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan diperbarui!');
    }

   public function konfirmasiPembayaran(Request $request, $id) 
{
    $transaksi = Transaksi::findOrFail($id);
    
    // Ambil status dari input select di form
    $transaksi->update([
        'status' => $request->status 
    ]);

    return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->status);
}

    public function pelangganDestroy($id) {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return back()->with('success', 'Pesanan berhasil dihapus');
    }

    // 6. LAPORAN PENJUALAN
  public function laporanPenjualan(Request $request) {
    // Statistik Akumulasi (Tetap muncul di atas)
    $mingguan = Transaksi::where('status', 'Selesai')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('total_harga');

    $bulanan = Transaksi::where('status', 'Selesai')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('total_harga');

    $tahunan = Transaksi::where('status', 'Selesai')
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('total_harga');

    // Query Utama untuk Tabel Laporan
    $query = Transaksi::where('status', 'Selesai')->with('details.novel');

    // FILTER RANGE TANGGAL (Tanggal Awal & Tanggal Akhir)
    if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
        $query->whereBetween('created_at', [$request->tanggal_awal . ' 00:00:00', $request->tanggal_akhir . ' 23:59:59']);
    } 
    // Filter Bulan & Tahun (Jika range tidak diisi)
    elseif ($request->filled('bulan') || $request->filled('tahun')) {
        if ($request->filled('bulan')) $query->whereMonth('created_at', $request->bulan);
        if ($request->filled('tahun')) $query->whereYear('created_at', $request->tahun);
    }

    $transaksiSukses = $query->latest()->get();

    return view('admin.laporan', compact('mingguan', 'bulanan', 'tahunan', 'transaksiSukses'));
}
}