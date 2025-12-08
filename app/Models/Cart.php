<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'peternak_id',
        'stok_benih_id',
        'jumlah',
        'harga',
        'subtotal'
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    // Relasi ke User (Pembudidaya)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Peternak
    public function peternak()
    {
        return $this->belongsTo(Peternak::class);
    }

    // Relasi ke Stok Benih
    public function stokBenih()
    {
        return $this->belongsTo(StokBenih::class);
    }
}