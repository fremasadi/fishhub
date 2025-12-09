<?php

namespace App\Http\Controllers\Peternak;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        // Ambil ID peternak
        $peternak = Auth::user()->peternak;

        // Jika belum punya profil peternak
        if (!$peternak) {
            abort(403, "Anda bukan peternak.");
        }

        // Ambil semua pesanan dimana peternak_id sama dengan peternak login
        $pesanan = Pesanan::with(['pembudidaya', 'stok'])
            ->where('peternak_id', $peternak->id)
            ->orderBy('tanggal_pesan', 'desc')
            ->paginate(10);

        return view('peternak.pesanan.index', compact('pesanan'));
    }
}
