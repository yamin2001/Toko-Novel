<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'alamat',
        'nomor_hp',
        'novel_id',
    ];

    public function novel()
    {
        return $this->belongsTo(Novel::class, 'novel_id');
    }
    public $timestamps = true; 
}