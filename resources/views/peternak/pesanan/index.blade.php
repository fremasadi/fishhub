@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4">Pesanan Masuk</h1>

    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Pembeli</th>
                            <th>Jenis Benih</th>
                            <th>Qty</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal Pesan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pesanan as $p)
                            <tr>
                                <td>{{ $loop->iteration + ($pesanan->currentPage() - 1) * $pesanan->perPage() }}</td>

                                <td>{{ $p->pembudidaya->name ?? '-' }}</td>

                                <td>{{ $p->stok->jenis ?? '-' }}</td>

                                <td>{{ $p->total_quantity }} ekor</td>

                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>

                                <td>
                                    <span>
                                        {{ ucfirst($p->status_pesanan) }}
                                    </span>
                                </td>

                                <td>{{ $p->tanggal_pesan->format('d M Y') }}</td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="10" class="text-muted py-3">
                                    Belum ada pesanan untuk Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pesanan->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
