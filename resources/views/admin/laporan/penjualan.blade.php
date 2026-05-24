@extends('layouts.app')

@php
    $isPrint = $isPrint ?? false;
@endphp

@push('styles')
    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 12mm;
            }

            .sidebar,
            .topbar,
            footer,
            .no-print {
                display: none !important;
            }

            #content-wrapper,
            #content,
            .container-fluid {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
                page-break-inside: avoid;
            }

            .table {
                font-size: 11px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Laporan Penjualan</h1>
                <p class="text-muted mb-0">Rekap seluruh penjualan benih dari pesanan yang pembayarannya berhasil.</p>
                @if($isPrint)
                    <p class="text-muted small mb-0">Dicetak pada {{ now()->format('d M Y H:i') }}</p>
                @endif
            </div>
            @unless($isPrint)
                <a href="{{ route('admin.laporan.penjualan', array_merge(request()->except('page'), ['print' => 1])) }}"
                    target="_blank" class="btn btn-danger btn-sm no-print">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
            @endunless
        </div>

        <div class="card shadow mb-4 no-print">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.penjualan') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control form-control-sm"
                            value="{{ request('tanggal_awal') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control form-control-sm"
                            value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Peternak</label>
                        <select name="peternak_id" class="form-control form-control-sm">
                            <option value="">Semua Peternak</option>
                            @foreach($peternaks as $peternak)
                                <option value="{{ $peternak->id }}" {{ request('peternak_id') == $peternak->id ? 'selected' : '' }}>
                                    {{ $peternak->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.laporan.penjualan') }}" class="btn btn-secondary btn-sm">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Penjualan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Benih Terjual
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($totalBenihTerjual) }} ekor
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fish fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Pesanan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($totalPesanan) }} pesanan
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Peternak Terjual
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($totalPeternak) }} peternak
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekap Per Peternak</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Peternak</th>
                                <th class="text-center">Total Pesanan</th>
                                <th class="text-center">Terjual</th>
                                <th class="text-end">Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekapPeternak as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $item->nama_peternak }}</td>
                                    <td class="text-center">{{ number_format($item->total_pesanan) }}</td>
                                    <td class="text-center">{{ number_format($item->total_qty) }} ekor</td>
                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($item->total_penjualan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada data penjualan pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekap Per Benih</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Peternak</th>
                                <th>Jenis Benih</th>
                                <th>Ukuran</th>
                                <th>Kualitas</th>
                                <th class="text-center">Total Pesanan</th>
                                <th class="text-center">Terjual</th>
                                <th class="text-end">Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekapBenih as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_peternak }}</td>
                                    <td class="fw-semibold">{{ $item->jenis }}</td>
                                    <td>{{ $item->ukuran }}</td>
                                    <td>{{ $item->kualitas }}</td>
                                    <td class="text-center">{{ number_format($item->total_pesanan) }}</td>
                                    <td class="text-center">{{ number_format($item->total_qty) }} ekor</td>
                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($item->total_penjualan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada data penjualan pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Penjualan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Peternak</th>
                                <th>Pembudidaya</th>
                                <th>Benih</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($detailPenjualan as $detail)
                                <tr>
                                    <td>
                                        @if($isPrint)
                                            {{ $loop->iteration }}
                                        @else
                                            {{ $loop->iteration + ($detailPenjualan->currentPage() - 1) * $detailPenjualan->perPage() }}
                                        @endif
                                    </td>
                                    <td>{{ $detail->pesanan?->tanggal_pesan?->format('d M Y') ?? '-' }}</td>
                                    <td>{{ $detail->pesanan?->peternak?->user?->name ?? '-' }}</td>
                                    <td>{{ $detail->pesanan?->pembudidaya?->name ?? '-' }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $detail->stokBenih?->jenis ?? '-' }}</div>
                                        <small class="text-muted">
                                            {{ $detail->stokBenih?->ukuran ?? '-' }} | {{ $detail->stokBenih?->kualitas ?? '-' }}
                                        </small>
                                    </td>
                                    <td class="text-center">{{ number_format($detail->qty) }} ekor</td>
                                    <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada detail penjualan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @unless($isPrint)
                    <div class="mt-3">
                        {{ $detailPenjualan->links() }}
                    </div>
                @endunless
            </div>
        </div>
    </div>
@endsection

@if($isPrint)
    @push('scripts')
        <script>
            window.addEventListener('load', () => window.print());
        </script>
    @endpush
@endif
