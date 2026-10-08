<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang'; // Sesuaikan dengan nama tabel di phpMyAdmin

    protected $fillable = [
        'user_id',
        'novel_id',
        'jumlah',
    ];

    // Relasi ke Novel (Untuk ambil judul, harga, dan gambar)
    public function novel()
    {
        return $this->belongsTo(Novel::class, 'novel_id');
    }

    // Relasi ke User (Pemilik keranjang)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}