<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanans';

    protected $fillable = [
        'pesanan_id',
        'stok_id',
        'qty',
        'harga_satuan',
    ];

    protected $casts = [
        'qty' => 'integer',
        'harga_satuan' => 'decimal:2',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function stokBenih(): BelongsTo
{
    return $this->belongsTo(StokBenih::class, 'stok_id', 'id');
}


    public function getSubtotalAttribute(): float
    {
        return $this->qty * $this->harga_satuan;
    }
}
