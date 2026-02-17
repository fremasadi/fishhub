<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembudidaya extends Model
{
    use HasFactory;

    protected $table = 'pembudidayas';

    protected $fillable = [
        'user_id',
        'no_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
