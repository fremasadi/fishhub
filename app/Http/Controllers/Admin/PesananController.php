<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
{
    $pesanans = Pesanan::with(['pembudidaya', 'peternak', 'stok', 'details'])
        ->orderBy('tanggal_pesan', 'DESC')
        ->paginate(10);

    return view('admin.pesanan.index', compact('pesanans'));
}


    public function show($id)
    {
        $pesanan = Pesanan::with(['pembudidaya', 'peternak', 'stok', 'details.stokBenih'])
            ->findOrFail($id);

        return view('admin.pesanan.show', compact('pesanan'));
    }
}
