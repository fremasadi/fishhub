@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h4 mb-4">Detail Pesanan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Pembudidaya:</strong> {{ $pesanan->pembudidaya->name ?? '—' }}</p>
            <p><strong>Peternak:</strong> {{ $pesanan->peternak->name ?? '—' }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ $pesanan->tanggal_pesan->format('d M Y') }}</p>
            <p><strong>Status:</strong>
                <span class="badge bg-info">{{ $pesanan->status_pesanan }}</span>
            </p>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <h5 class="mb-3">Detail Item</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis Benih</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pesanan->details as $d)
                            <tr>
                                <td>{{ $d->stokBenih->jenis ?? '-' }}</td>
                                <td>{{ $d->qty }}</td>
                                <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        <tr class="table-light">
                            <th colspan="3">Total</th>
                            <th>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
