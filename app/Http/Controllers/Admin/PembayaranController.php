<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('pesanan.pembudidaya')
            ->orderBy('transaction_time', 'DESC')
            ->paginate(10);

        return view('admin.pembayaran.index', compact('pembayarans'));
    }
}
