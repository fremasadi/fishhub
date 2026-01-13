@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Peternak</h1>
        <a href="{{ route('peternaks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- INFORMASI UTAMA --}}
    <div class="row">

        {{-- DATA PETERNak --}}
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header font-weight-bold">
                    Informasi Peternak
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="40%">Nama</th>
                            <td>{{ $peternak->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $peternak->user->email }}</td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td>{{ $peternak->no_hp }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $peternak->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($peternak->status_aktif)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Koordinat</th>
                            <td>
                                {{ $peternak->latitude ?? '-' }},
                                {{ $peternak->longitude ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- RINGKASAN --}}
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header font-weight-bold">
                    Ringkasan Aktivitas
                </div>
                <div class="card-body">
                    <div class="row text-center">

                        <div class="col-6 mb-3">
                            <h2 class="text-primary">
                                {{ $peternak->stokBenihs->count() }}
                            </h2>
                            <small class="text-muted">Jumlah Stok Benih</small>
                        </div>

                        <div class="col-6 mb-3">
                            <h2 class="text-success">
                                {{ $peternak->pengambilans->count() }}
                            </h2>
                            <small class="text-muted">Total Pengambilan</small>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABEL STOK BENIH --}}
    <div class="card shadow mb-4">
        <div class="card-header font-weight-bold">
            Daftar Stok Benih
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Jenis</th>
                            <th>Ukuran</th>
                            <th>Kualitas</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peternak->stokBenihs as $stok)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $stok->jenis }}</td>
                                <td>{{ $stok->ukuran }} cm</td>
                                <td>{{ ucfirst($stok->kualitas) }}</td>
                                <td>{{ number_format($stok->jumlah) }}</td>
                                <td>Rp {{ number_format($stok->harga, 0, ',', '.') }}</td>
                                <td>
                                    {{ $stok->status_stok === 'tersedia' ? 'Tersedia' : 'Habis' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">
                                    Belum ada stok benih
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection