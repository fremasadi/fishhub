<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'pesanan_id',
        'pembudidaya_id',
        'peternak_id',
        'rating',
        'komentar',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function pembudidaya(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembudidaya_id');
    }

    public function peternak(): BelongsTo
    {
        return $this->belongsTo(Peternak::class, 'peternak_id');
    }
}
