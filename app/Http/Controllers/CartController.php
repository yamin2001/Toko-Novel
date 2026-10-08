<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Tampilkan Isi Keranjang
    public function index()
    {
        $cartItems = Keranjang::where('user_id', Auth::id())->with('novel')->get();
        $totalHarga = $cartItems->sum(function($item) {
            return $item->novel->harga * $item->jumlah;
        });

        return view('pelanggan.keranjang', compact('cartItems', 'totalHarga'));
    }

    // 2. Tambah ke Keranjang
    public function add(Request $request, $id)
    {
        $novel = Novel::findOrFail($id);
        
        // Cek apakah item sudah ada di keranjang user
        $cartItem = Keranjang::where('user_id', Auth::id())
                             ->where('novel_id', $id)
                             ->first();

        if ($cartItem) {
            $cartItem->increment('jumlah', $request->jumlah ?? 1);
        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'novel_id' => $id,
                'jumlah' => $request->jumlah ?? 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Berhasil masuk keranjang!');
    }

    // 3. Hapus Item dari Keranjang
    public function destroy($id)
    {
        Keranjang::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Berhasil dihapus');
    }
}