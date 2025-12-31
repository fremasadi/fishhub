@extends('layouts.app')

@section('title', 'Detail Pengambilan')

@section('content')
    <div class="container-fluid">

        <a href="{{ route('peternak.pengambilan.index') }}" class="btn btn-secondary mb-3">
            ← Kembali
        </a>

        <div class="row">

            <!-- LEFT -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <h5 class="fw-bold mb-3">📄 Detail Pengambilan</h5>

                        <table class="table table-sm">
                            <tr>
                                <th width="200">Pembudidaya</th>
                                <td>{{ $pengambilan->pesanan->pembudidaya->name }}</td>
                            </tr>
                            <tr>
                                <th>Status Pengambilan</th>
                                <td>
                                    <span
                                        class="badge
                                    @if ($pengambilan->status_pengambilan === 'Menunggu') bg-warning
                                    @elseif($pengambilan->status_pengambilan === 'Siap Diambil') bg-info
                                    @elseif($pengambilan->status_pengambilan === 'Diterima') bg-success
                                    @else bg-secondary @endif
                                ">
                                        {{ $pengambilan->status_pengambilan }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengambilan</th>
                                <td>
                                    {{ $pengambilan->tanggal_pengambilan ? $pengambilan->tanggal_pengambilan->format('d M Y H:i') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $pengambilan->catatan ?? '-' }}</td>
                            </tr>
                        </table>

                    </div>
                </div>

                <!-- LIST BENIH -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">🐟 Detail Benih</h5>

                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Jenis</th>
                                    <th>Ukuran</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengambilan->pesanan->details as $detail)
                                    <tr>
                                        <td>{{ $detail->stokBenih->jenis }}</td>
                                        <td>{{ $detail->stokBenih->ukuran }}</td>
                                        <td>{{ $detail->qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="fw-bold mb-3">⚙️ Aksi</h5>

                        @if ($pengambilan->status_pengambilan === 'Menunggu')
                            <form method="POST" action="{{ route('peternak.pengambilan.ready', $pengambilan->id) }}">
                                @csrf
                                <button class="btn btn-info w-100 mb-2">
                                    Tandai Siap Diambil
                                </button>
                            </form>
                        @endif

                        @if ($pengambilan->status_pengambilan === 'Siap Diambil')
                            <form method="POST" action="{{ route('peternak.pengambilan.confirm', $pengambilan->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-2">
                                    <label class="form-label">Bukti Serah (opsional)</label>
                                    <input type="file" name="bukti_serah" class="form-control">
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="catatan" class="form-control"></textarea>
                                </div>

                                <button class="btn btn-success w-100">
                                    Konfirmasi Diterima
                                </button>
                            </form>
                        @endif

                        @if ($pengambilan->status_pengambilan === 'Diterima')
                            <div class="alert alert-success text-center">
                                ✅ Pengambilan telah selesai
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
