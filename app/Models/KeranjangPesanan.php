<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangPesanan extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $fillable = [
        'produk_id',
        'jumlah',
        'status_id',
    ];

    public function status() 
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
