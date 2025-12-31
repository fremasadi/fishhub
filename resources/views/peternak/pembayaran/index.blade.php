@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4">Riwayat Pembayaran</h1>

        <div class="card shadow">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Kode Pesanan</th>
                                <th>Metode</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($pembayaran as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($pembayaran->currentPage() - 1) * $pembayaran->perPage() }}
                                    </td>

                                    <td>{{ $item->order_id }}</td>

                                    <td>{{ $item->getPaymentMethodLabel() }}</td>

                                    <td>Rp {{ number_format($item->gross_amount, 0, ',', '.') }}</td>

                                    <td>
                                        <span class="badge bg-{{ $item->getStatusBadgeClass() }}">
                                            {{ $item->getStatusLabel() }}
                                        </span>
                                    </td>

                                    <td>{{ $item->transaction_time?->format('d M Y H:i') }}</td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted py-3">
                                        Belum ada pembayaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pembayaran->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
