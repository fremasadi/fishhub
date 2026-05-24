<?php

namespace App\Http\Controllers\Peternak;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $peternak = Auth::user()->peternak;
        $isPrint = $request->boolean('print');

        if (!$peternak) {
            abort(403, 'Profil peternak tidak ditemukan.');
        }

        $baseQuery = DetailPesanan::query()
            ->whereHas('pesanan', function ($query) use ($peternak, $request) {
                $query->where('peternak_id', $peternak->id)
                    ->whereHas('pembayaran', function ($pembayaran) {
                        $pembayaran->whereIn('transaction_status', ['settlement', 'capture']);
                    });

                if ($request->filled('tanggal_awal')) {
                    $query->whereDate('tanggal_pesan', '>=', $request->tanggal_awal);
                }

                if ($request->filled('tanggal_akhir')) {
                    $query->whereDate('tanggal_pesan', '<=', $request->tanggal_akhir);
                }
            });

        $totalPenjualan = (clone $baseQuery)
            ->selectRaw('COALESCE(SUM(qty * harga_satuan), 0) as total')
            ->value('total');

        $totalBenihTerjual = (clone $baseQuery)->sum('qty');
        $totalPesanan = (clone $baseQuery)->distinct()->count('pesanan_id');

        $rekapBenih = (clone $baseQuery)
            ->leftJoin('stok_benihs', 'detail_pesanans.stok_id', '=', 'stok_benihs.id')
            ->select([
                'detail_pesanans.stok_id',
                DB::raw("COALESCE(stok_benihs.jenis, 'Benih Tidak Ditemukan') as jenis"),
                DB::raw("COALESCE(stok_benihs.ukuran, '-') as ukuran"),
                DB::raw("COALESCE(stok_benihs.kualitas, '-') as kualitas"),
                DB::raw('SUM(detail_pesanans.qty) as total_qty'),
                DB::raw('SUM(detail_pesanans.qty * detail_pesanans.harga_satuan) as total_penjualan'),
                DB::raw('COUNT(DISTINCT detail_pesanans.pesanan_id) as total_pesanan'),
            ])
            ->groupBy('detail_pesanans.stok_id', 'stok_benihs.jenis', 'stok_benihs.ukuran', 'stok_benihs.kualitas')
            ->orderByDesc('total_penjualan')
            ->get();

        $detailPenjualanQuery = (clone $baseQuery)
            ->with(['pesanan.pembudidaya', 'pesanan.pembayaran', 'stokBenih'])
            ->latest();

        $detailPenjualan = $isPrint
            ? $detailPenjualanQuery->get()
            : $detailPenjualanQuery->paginate(10)->withQueryString();

        return view('peternak.laporan.penjualan', compact(
            'detailPenjualan',
            'isPrint',
            'rekapBenih',
            'totalPenjualan',
            'totalBenihTerjual',
            'totalPesanan'
        ));
    }
}
