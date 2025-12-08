<?php

namespace App\Http\Controllers;

use App\Models\Peternak;
use App\Models\StokBenih;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil stok benih yang sudah divalidasi dan tersedia
        $stokBenihs = StokBenih::with(['peternak.user'])
            ->where('status_validasi', 'Terverifikasi')
            ->where('status_stok', 'Tersedia')
            ->orderBy('tanggal_input', 'desc')
            ->get();

        // Ambil data peternak yang aktif beserta koordinatnya
        $peternaks = Peternak::with('user')
            ->where('status_aktif', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('front.welcome', compact('stokBenihs', 'peternaks'));
    }
}