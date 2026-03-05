<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('pesanan.pembudidaya');

        if ($request->filled('bulan')) {
            $query->whereMonth('transaction_time', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('transaction_time', $request->tahun);
        }

        $subtotal = (clone $query)->sum('gross_amount');

        $pembayarans = $query->orderBy('transaction_time', 'DESC')->paginate(10)->withQueryString();

        return view('admin.pembayaran.index', compact('pembayarans', 'subtotal'));
    }
}
