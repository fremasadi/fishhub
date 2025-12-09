@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4">Daftar Pembayaran</h1>

    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Pembeli</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Transaksi</th>
                            <th>Tanggal Settlement</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pembayarans as $pay)
                            <tr>
                                <td>{{ $loop->iteration + ($pembayarans->currentPage() - 1) * $pembayarans->perPage() }}</td>

                                <td>{{ $pay->order_id }}</td>

                                <td>{{ $pay->pesanan->pembudidaya->name ?? '-' }}</td>

                                <td>{{ $pay->payment_method_label }}</td>

                                <td>Rp {{ number_format($pay->gross_amount, 0, ',', '.') }}</td>

                                <td>
                                    <span class="badge bg-{{ $pay->status_badge_class }}">
                                        {{ $pay->status_label }}
                                    </span>
                                </td>

                                <td>
                                    {{ $pay->transaction_time ? $pay->transaction_time->format('d M Y H:i') : '-' }}
                                </td>

                                <td>
                                    {{ $pay->settlement_time ? $pay->settlement_time->format('d M Y H:i') : '-' }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="10" class="text-muted py-3">
                                    Belum ada data pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pembayarans->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
