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
    public function index(Request $request)
    {
        $peternak = Auth::user()->peternak;

        $query = Pembayaran::whereHas('pesanan', function ($q) use ($peternak) {
            $q->where('peternak_id', $peternak->id);
        });

        if ($request->filled('bulan')) {
            $query->whereMonth('transaction_time', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('transaction_time', $request->tahun);
        }

        $subtotal = (clone $query)->sum('gross_amount');

        $pembayaran = $query->latest()->paginate(10)->withQueryString();

        return view('peternak.pembayaran.index', compact('pembayaran', 'subtotal'));
    }
}
