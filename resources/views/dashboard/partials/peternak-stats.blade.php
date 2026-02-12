<!-- Content Row - Stats Cards -->
<div class="row">

    <!-- Total Benih Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
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

    <!-- Jenis Benih Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jenis Benih
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['jenisBenih'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-database fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pesanan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
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

    <!-- Total Pendapatan Card -->
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

    <!-- Pendapatan Bulan Ini Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pendapatan Bulan Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($data['pendapatanBulanIni'], 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Alert Validasi Benih -->
@if($data['benihValidasi'] > 0)
<div class="row">
    <div class="col-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Perhatian!</strong> Anda memiliki {{ $data['benihValidasi'] }} stok benih yang menunggu validasi admin.
            <a href="{{ route('benih.index') }}" class="alert-link">Lihat detail</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
@endif

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

    <!-- Info Peternak -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Peternak</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="avatar-circle bg-primary text-white mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                        {{ strtoupper(substr($data['peternak']->user->name, 0, 1)) }}
                    </div>
                    <h5 class="mb-0">{{ $data['peternak']->user->name }}</h5>
                    <p class="text-muted mb-0">{{ $data['peternak']->user->email }}</p>
                </div>
                <hr>
                <div class="mb-2">
                    <i class="fas fa-phone text-primary mr-2"></i>
                    <span>{{ $data['peternak']->no_hp }}</span>
                </div>
                <div class="mb-2">
                    <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                    <span>{{ $data['peternak']->alamat }}</span>
                </div>
                <div class="mb-2">
                    <i class="fas fa-check-circle text-success mr-2"></i>
                    <span>Status:
                        @if($data['peternak']->status_aktif)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </span>
                </div>
                <hr>
                <div class="text-center">
                    <a href="{{ route('benih.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Stok Benih
                    </a>
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
                <a href="{{ route('peternak.pesanan.index') }}" class="btn btn-sm btn-primary">
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
                                <th>Benih</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['recentPesanan'] as $pesanan)
                                <tr>
                                    <td>{{ $pesanan->tanggal_pesan->format('d/m/Y') }}</td>
                                    <td>{{ $pesanan->pembudidaya->name }}</td>
                                    <td>{{ $pesanan->stok->jenis }}</td>
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

    <!-- Stok Benih -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Stok Benih Anda</h6>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($data['benihStok'] as $benih)
                    <div class="mb-3 p-2 border-left border-primary" style="border-left-width: 3px !important;">
                        {{-- <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0">{{ $benih->jenis }}</h6>
                            @if($benih->status_validasi === 'approved')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($benih->status_validasi === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </div> --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $benih->ukuran }} | {{ $benih->kualitas }}</small>
                            <span class="badge badge-primary">{{ number_format($benih->jumlah) }} ekor</span>
                        </div>
                        <div class="mt-1">
                            <small class="text-success font-weight-bold">Rp {{ number_format($benih->harga, 0, ',', '.') }}</small>
                        </div>
                        @if(!$loop->last)
                            <hr class="my-2">
                        @endif
                    </div>
                @empty
                    <p class="text-center text-muted mb-0">Belum ada stok benih</p>
                    <div class="text-center mt-3">
                        <a href="{{ route('benih.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Stok Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>