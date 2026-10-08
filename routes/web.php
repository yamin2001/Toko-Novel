<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, PelangganController, AdminController, 
    CartController, CheckoutController
};

/* --- 1. HALAMAN PUBLIK --- */
// Menangani error 'welcome' not defined dengan memberi nama pada route utama
Route::get('/', [PelangganController::class, 'index'])->name('welcome');

Route::get('/katalog', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('/novel/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');


/* --- 2. LOGIN & REGISTER (GUEST) --- */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


/* --- 3. AKSES PELANGGAN (AUTH) --- */
Route::middleware('auth')->group(function () {
    // Logout harus menggunakan POST untuk menghindari error 419
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/pesanan-saya', [PelangganController::class, 'pesananSaya'])->name('pesanan.saya');
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('checkout.proses');
});


/* --- 4. AKSES KHUSUS ADMIN (IS_ADMIN) --- */
// Prefix 'admin' berarti URL-nya akan menjadi localhost:8000/admin/...
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard & CRUD Novel
    Route::get('/dashboard', [AdminController::class, 'index'])->name('index'); 
    Route::get('/novel/tambah', [AdminController::class, 'create'])->name('create');
    Route::post('/novel/simpan', [AdminController::class, 'store'])->name('store');
    
    // Route Edit & Update untuk mengatasi error "Method edit does not exist"
    Route::get('/novel/edit/{id}', [AdminController::class, 'edit'])->name('edit');
    Route::put('/novel/update/{id}', [AdminController::class, 'update'])->name('update');
    
    Route::delete('/novel/hapus/{id}', [AdminController::class, 'destroy'])->name('destroy');

    // Manajemen Pesanan & Laporan
    Route::get('/pesanan', [AdminController::class, 'pelangganIndex'])->name('pelanggan.index');
    
    // Perbaikan: gunakan nama konfirmasiPembayaran sesuai di Controller
    Route::post('/pesanan/konfirmasi/{id}', [AdminController::class, 'konfirmasiPembayaran'])->name('pelanggan.konfirmasi');
    
    Route::delete('/pesanan/hapus/{id}', [AdminController::class, 'pelangganDestroy'])->name('pelanggan.destroy');
    Route::get('/laporan', [AdminController::class, 'laporanPenjualan'])->name('laporan');
});