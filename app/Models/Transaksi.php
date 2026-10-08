<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'nama_penerima',
        'alamat_pengiriman',
        'nomor_hp',
        'total_harga',
        'bukti_transfer',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
    
    public function scopeSukses($query)
    {
        return $query->where('status', 'Selesai');
    }
}