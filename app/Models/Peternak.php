<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peternak extends Model
{
    use HasFactory;

     protected $table = 'peternaks'; // ← TAMBAHKAN INI!


    protected $fillable = [
        'user_id',
        'alamat',
        'no_hp',
        'status_aktif',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke stok benih
    public function stokBenihs()
    {
        return $this->hasMany(StokBenih::class, 'peternak_id');
    }

    public function pengambilans()
{
    return $this->hasMany(Pengambilan::class, 'peternak_id');
}
}
