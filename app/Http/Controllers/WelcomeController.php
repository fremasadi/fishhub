<?php

namespace App\Http\Controllers;

use App\Models\Peternak;
use App\Models\StokBenih;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $query = StokBenih::with(['peternak.user'])
            ->where('status_stok', 'Tersedia');

        // FILTER JENIS IKAN
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $stokBenihs = $query
            ->orderBy('tanggal_input', 'desc')
            ->get();

        $peternaks = Peternak::with('user')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('front.welcome', compact('stokBenihs', 'peternaks'));
    }
}