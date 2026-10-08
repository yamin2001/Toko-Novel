<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi'; // Nama tabel yang Bos buat tadi
    protected $fillable = ['transaksi_id', 'novel_id', 'jumlah', 'subtotal'];

    public function novel() {
        return $this->belongsTo(Novel::class, 'novel_id');
    }
}