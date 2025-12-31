<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = [
        'pembudidaya_id',
        'peternak_id',
        'stok_id',
        'tanggal_pesan',
        'total_harga',
        'status_pesanan',
    ];

    protected $casts = [
        'tanggal_pesan' => 'date',
        'total_harga' => 'decimal:2',
    ];

    /**
     * Relasi ke User (Pembudidaya)
     */
    public function pembudidaya(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembudidaya_id');
    }

    /**
     * Relasi ke Peternak
     */
    public function peternak(): BelongsTo
    {
        return $this->belongsTo(Peternak::class, 'peternak_id');
    }

    /**
     * Relasi ke Stok Benih
     */
    public function stok(): BelongsTo
    {
        return $this->belongsTo(StokBenih::class, 'stok_id', 'id');
    }

    /**
     * Relasi ke Detail Pesanan
     */
    public function details(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    /**
     * Relasi ke Pembayaran
     */
    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'transaksi_id');
    }

    /**
     * Get total quantity
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->details->sum('qty');
    }

    /**
     * Check if paid
     */
    public function isPaid(): bool
    {
        return in_array($this->status_pesanan, ['Dibayar', 'Selesai']);
    }

    public function pengambilan()
{
    return $this->hasOne(Pengambilan::class, 'pesanan_id');
}
}

