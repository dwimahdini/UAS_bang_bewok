<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPesanan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pesanan';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'order_id',
        'status_id',
        'jumlah',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'order_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
