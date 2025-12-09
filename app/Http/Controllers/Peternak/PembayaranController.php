<?php

namespace App\Http\Controllers\Peternak;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * Menampilkan daftar pembayaran yang terkait dengan peternak yang login.
     */
    public function index()
    {
        $peternak = Auth::user()->peternak;

        // Ambil pembayaran berdasarkan pesanan yang dimiliki peternak
        $pembayaran = Pembayaran::whereHas('pesanan', function ($query) use ($peternak) {
            $query->where('peternak_id', $peternak->id);
        })
        ->latest()
        ->paginate(10);

        return view('peternak.pembayaran.index', compact('pembayaran'));
    }
}
