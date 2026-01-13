<!-- Content Row - Stats Cards -->
<div class="row">

    <!-- Total Users Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Users
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['totalUsers'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Peternak Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Peternak Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['totalPeternak'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Benih Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Stok Benih Tersedia
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($data['totalBenih']) }} <small>ekor</small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-fish fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Total Pendapatan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pendapatan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($data['totalPendapatan'], 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row - Pesanan Stats -->
<div class="row">

    <!-- Total Pesanan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Total Pesanan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['totalPesanan'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Pending Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pesanan Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['pesananPending'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Diproses Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pesanan Diproses
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['pesananDiproses'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-spinner fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Selesai Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pesanan Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['pesananSelesai'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row - Charts and Tables -->
<div class="row">

    <!-- Chart Pesanan -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Pesanan (6 Bulan Terakhir)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="chartPesanan" style="height: 320px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart Pembayaran -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Status Pembayaran</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-xs">Berhasil</span>
                        <span class="text-xs font-weight-bold">{{ $data['pembayaranSuccess'] }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 20px;">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ $data['totalPesanan'] > 0 ? ($data['pembayaranSuccess'] / $data['totalPesanan'] * 100) : 0 }}%">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-xs">Pending</span>
                        <span class="text-xs font-weight-bold">{{ $data['pembayaranPending'] }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 20px;">
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ $data['totalPesanan'] > 0 ? ($data['pembayaranPending'] / $data['totalPesanan'] * 100) : 0 }}%">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <span class="text-xs">Total Pendapatan</span>
                    <h4 class="mb-0 text-success font-weight-bold">
                        Rp {{ number_format($data['totalPendapatan'], 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row - Tables -->
<div class="row">

    <!-- Pesanan Terbaru -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Pesanan Terbaru</h6>
                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua <i class="fas fa-arrow-right fa-sm"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pembudidaya</th>
                                <th>Peternak</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['recentPesanan'] as $pesanan)
                                <tr>
                                    <td>{{ $pesanan->tanggal_pesan->format('d/m/Y') }}</td>
                                    <td>{{ $pesanan->pembudidaya->name }}</td>
                                    <td>{{ $pesanan->peternak->user->name }}</td>
                                    <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($pesanan->status_pesanan === 'Pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($pesanan->status_pesanan === 'Diproses')
                                            <span class="badge badge-info">Diproses</span>
                                        @elseif($pesanan->status_pesanan === 'Selesai')
                                            <span class="badge badge-success">Selesai</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $pesanan->status_pesanan }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Benih Populer -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Stok Benih Terbanyak</h6>
            </div>
            <div class="card-body">
                @forelse($data['topBenih'] as $benih)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0">{{ $benih->jenis }}</h6>
                            <small class="text-muted">{{ $benih->peternak->user->name }}</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $benih->ukuran }} | {{ $benih->kualitas }}</small>
                            <span class="badge badge-primary">{{ number_format($benih->jumlah) }} ekor</span>
                        </div>
                        @if(!$loop->last)
                            <hr class="my-2">
                        @endif
                    </div>
                @empty
                    <p class="text-center text-muted mb-0">Belum ada stok benih</p>
                @endforelse
            </div>
        </div>
    </div> --}}

</div>