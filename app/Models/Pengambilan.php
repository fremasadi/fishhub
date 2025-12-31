<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengambilan extends Model
{
    protected $table = 'pengambilans';

    protected $fillable = [
        'pesanan_id',
        'pembudidaya_id',
        'peternak_id',
        'tanggal_pengambilan',
        'status_pengambilan',
        'bukti_serah',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pengambilan' => 'datetime',
    ];

    /* ================= RELATIONS ================= */

    /**
     * Relasi ke Pesanan
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    /**
     * Relasi ke Pembudidaya (User)
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

    /* ================= HELPER ================= */

    public function isMenunggu(): bool
    {
        return $this->status_pengambilan === 'Menunggu';
    }

    public function isSiapDiambil(): bool
    {
        return $this->status_pengambilan === 'Siap Diambil';
    }

    public function isDiserahkan(): bool
    {
        return $this->status_pengambilan === 'Diserahkan';
    }

    public function isDiterima(): bool
    {
        return $this->status_pengambilan === 'Diterima';
    }

    public function isDibatalkan(): bool
    {
        return $this->status_pengambilan === 'Dibatalkan';
    }
}