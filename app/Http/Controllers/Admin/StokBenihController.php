<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StokBenih;
use Illuminate\Http\Request;

class StokBenihController extends Controller
{
    public function index()
    {
        // Ambil stok benih beserta peternak dan user
        $stok = StokBenih::with(['peternak.user'])
            ->orderBy('tanggal_input', 'desc')
            ->paginate(10);

        return view('admin.stok_benih.index', compact('stok'));
    }
}
