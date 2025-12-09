<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Peternak;
use App\Models\StokBenih;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return $this->adminDashboard();
        } else {
            return $this->peternakDashboard($user);
        }
    }

    private function adminDashboard()
    {
        $data = [
            // Total statistik
            'totalUsers' => User::count(),
            'totalPeternak' => Peternak::where('status_aktif', true)->count(),
            'totalBenih' => StokBenih::where('status_stok', 'tersedia')->sum('jumlah'),
            'jenisBenih' => StokBenih::distinct('jenis')->count('jenis'),
            
            // Pesanan statistik
            'totalPesanan' => Pesanan::count(),
            'pesananPending' => Pesanan::where('status_pesanan', 'Pending')->count(),
            'pesananDiproses' => Pesanan::where('status_pesanan', 'Diproses')->count(),
            'pesananSelesai' => Pesanan::where('status_pesanan', 'Selesai')->count(),
            
            // Pembayaran statistik
            'totalPendapatan' => Pembayaran::whereIn('transaction_status', ['settlement', 'capture'])->sum('gross_amount'),
            'pembayaranPending' => Pembayaran::where('transaction_status', 'pending')->count(),
            'pembayaranSuccess' => Pembayaran::whereIn('transaction_status', ['settlement', 'capture'])->count(),
            
            // Pesanan terbaru
            'recentPesanan' => Pesanan::with(['pembudidaya', 'peternak.user', 'stok'])
                ->latest()
                ->limit(5)
                ->get(),
            
            // Stok benih populer
            'topBenih' => StokBenih::with('peternak.user')
                ->where('status_stok', 'tersedia')
                ->orderBy('jumlah', 'desc')
                ->limit(5)
                ->get(),
            
            // Grafik pesanan per bulan (6 bulan terakhir)
            'chartPesanan' => $this->getChartPesananAdmin(),
            
            // Peternak aktif terbaru
            'recentPeternak' => Peternak::with('user')
                ->where('status_aktif', true)
                ->latest()
                ->limit(5)
                ->get(),
        ];
        
        return view('dashboard', compact('data'));
    }

    private function peternakDashboard($user)
    {
        $peternak = Peternak::where('user_id', $user->id)->first();
        
        if (!$peternak) {
            return redirect()->route('profile.complete')
                ->with('warning', 'Silakan lengkapi profil peternak Anda terlebih dahulu.');
        }
        
        $data = [
            'peternak' => $peternak,
            
            // Stok statistik
            'totalBenih' => StokBenih::where('peternak_id', $peternak->id)
                ->where('status_stok', 'tersedia')
                ->sum('jumlah'),
            'jenisBenih' => StokBenih::where('peternak_id', $peternak->id)->count(),
            'benihValidasi' => StokBenih::where('peternak_id', $peternak->id)
                ->where('status_validasi', 'pending')
                ->count(),
            
            // Pesanan statistik
            'totalPesanan' => Pesanan::where('peternak_id', $peternak->id)->count(),
            'pesananPending' => Pesanan::where('peternak_id', $peternak->id)
                ->where('status_pesanan', 'Pending')->count(),
            'pesananDiproses' => Pesanan::where('peternak_id', $peternak->id)
                ->where('status_pesanan', 'Diproses')->count(),
            'pesananSelesai' => Pesanan::where('peternak_id', $peternak->id)
                ->where('status_pesanan', 'Selesai')->count(),
            
            // Pendapatan
            'totalPendapatan' => Pembayaran::whereHas('pesanan', function($q) use ($peternak) {
                    $q->where('peternak_id', $peternak->id);
                })
                ->whereIn('transaction_status', ['settlement', 'capture'])
                ->sum('gross_amount'),
            'pendapatanBulanIni' => Pembayaran::whereHas('pesanan', function($q) use ($peternak) {
                    $q->where('peternak_id', $peternak->id);
                })
                ->whereIn('transaction_status', ['settlement', 'capture'])
                ->whereMonth('settlement_time', now()->month)
                ->whereYear('settlement_time', now()->year)
                ->sum('gross_amount'),
            
            // Pesanan terbaru
            'recentPesanan' => Pesanan::with(['pembudidaya', 'stok', 'pembayaran'])
                ->where('peternak_id', $peternak->id)
                ->latest()
                ->limit(5)
                ->get(),
            
            // Stok benih
            'benihStok' => StokBenih::where('peternak_id', $peternak->id)
                ->orderBy('jumlah', 'desc')
                ->get(),
            
            // Grafik pesanan per bulan (6 bulan terakhir)
            'chartPesanan' => $this->getChartPesananPeternak($peternak->id),
        ];
        
        return view('dashboard', compact('data'));
    }

    private function getChartPesananAdmin()
    {
        $months = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $count = Pesanan::whereMonth('tanggal_pesan', $date->month)
                ->whereYear('tanggal_pesan', $date->year)
                ->count();
            
            $data[] = $count;
        }
        
        return [
            'labels' => $months,
            'data' => $data,
        ];
    }

    private function getChartPesananPeternak($peternakId)
    {
        $months = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $count = Pesanan::where('peternak_id', $peternakId)
                ->whereMonth('tanggal_pesan', $date->month)
                ->whereYear('tanggal_pesan', $date->year)
                ->count();
            
            $data[] = $count;
        }
        
        return [
            'labels' => $months,
            'data' => $data,
        ];
    }
}