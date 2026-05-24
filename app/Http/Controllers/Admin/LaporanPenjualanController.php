<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Peternak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $isPrint = $request->boolean('print');

        $baseQuery = DetailPesanan::query()
            ->whereHas('pesanan', function ($query) use ($request) {
                $query->whereHas('pembayaran', function ($pembayaran) {
                    $pembayaran->whereIn('transaction_status', ['settlement', 'capture']);
                });

                if ($request->filled('peternak_id')) {
                    $query->where('peternak_id', $request->peternak_id);
                }

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
        $totalPeternak = (clone $baseQuery)
            ->join('pesanans', 'detail_pesanans.pesanan_id', '=', 'pesanans.id')
            ->distinct()
            ->count('pesanans.peternak_id');

        $rekapBenih = (clone $baseQuery)
            ->leftJoin('stok_benihs', 'detail_pesanans.stok_id', '=', 'stok_benihs.id')
            ->leftJoin('pesanans', 'detail_pesanans.pesanan_id', '=', 'pesanans.id')
            ->leftJoin('peternaks', 'pesanans.peternak_id', '=', 'peternaks.id')
            ->leftJoin('users as peternak_users', 'peternaks.user_id', '=', 'peternak_users.id')
            ->select([
                'detail_pesanans.stok_id',
                'pesanans.peternak_id',
                DB::raw("COALESCE(peternak_users.name, 'Peternak Tidak Ditemukan') as nama_peternak"),
                DB::raw("COALESCE(stok_benihs.jenis, 'Benih Tidak Ditemukan') as jenis"),
                DB::raw("COALESCE(stok_benihs.ukuran, '-') as ukuran"),
                DB::raw("COALESCE(stok_benihs.kualitas, '-') as kualitas"),
                DB::raw('SUM(detail_pesanans.qty) as total_qty'),
                DB::raw('SUM(detail_pesanans.qty * detail_pesanans.harga_satuan) as total_penjualan'),
                DB::raw('COUNT(DISTINCT detail_pesanans.pesanan_id) as total_pesanan'),
            ])
            ->groupBy(
                'detail_pesanans.stok_id',
                'pesanans.peternak_id',
                'peternak_users.name',
                'stok_benihs.jenis',
                'stok_benihs.ukuran',
                'stok_benihs.kualitas'
            )
            ->orderByDesc('total_penjualan')
            ->get();

        $rekapPeternak = (clone $baseQuery)
            ->join('pesanans', 'detail_pesanans.pesanan_id', '=', 'pesanans.id')
            ->leftJoin('peternaks', 'pesanans.peternak_id', '=', 'peternaks.id')
            ->leftJoin('users as peternak_users', 'peternaks.user_id', '=', 'peternak_users.id')
            ->select([
                'pesanans.peternak_id',
                DB::raw("COALESCE(peternak_users.name, 'Peternak Tidak Ditemukan') as nama_peternak"),
                DB::raw('SUM(detail_pesanans.qty) as total_qty'),
                DB::raw('SUM(detail_pesanans.qty * detail_pesanans.harga_satuan) as total_penjualan'),
                DB::raw('COUNT(DISTINCT detail_pesanans.pesanan_id) as total_pesanan'),
            ])
            ->groupBy('pesanans.peternak_id', 'peternak_users.name')
            ->orderByDesc('total_penjualan')
            ->get();

        $detailPenjualanQuery = (clone $baseQuery)
            ->with(['pesanan.pembudidaya', 'pesanan.peternak.user', 'pesanan.pembayaran', 'stokBenih'])
            ->latest();

        $detailPenjualan = $isPrint
            ? $detailPenjualanQuery->get()
            : $detailPenjualanQuery->paginate(10)->withQueryString();

        $peternaks = Peternak::with('user')
            ->whereHas('user')
            ->get()
            ->sortBy(fn ($peternak) => $peternak->user->name)
            ->values();

        return view('admin.laporan.penjualan', compact(
            'detailPenjualan',
            'isPrint',
            'peternaks',
            'rekapBenih',
            'rekapPeternak',
            'totalBenihTerjual',
            'totalPenjualan',
            'totalPesanan',
            'totalPeternak'
        ));
    }
}
