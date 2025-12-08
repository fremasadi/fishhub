<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBenih extends Model
{
    protected $table = 'stok_benihs';
    protected $primaryKey = 'id';


    protected $fillable = [
        'peternak_id',
        'jenis',
        'jumlah',
        'ukuran',
        'kualitas',
        'status_validasi',
        'status_stok',
        'tanggal_input',
        'harga',      // <── tambah ini
        'image',      // <── tambah ini
    ];

    public function peternak()
    {
        return $this->belongsTo(Peternak::class, 'peternak_id');
    }
}
