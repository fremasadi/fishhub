@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4">Daftar Pesanan</h1>

    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Pembudidaya</th>
                            <th>Peternak</th>
                            <th>Jenis Benih</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal Pesan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pesanans as $p)
                            <tr>
                                <td>{{ $loop->iteration + ($pesanans->currentPage() - 1) * $pesanans->perPage() }}</td>

                                <td>{{ $p->pembudidaya->name ?? '—' }}</td>

                                <td>{{ $p->peternak->name ?? '—' }}</td>

                                <td>{{ $p->stok->jenis ?? '-' }}</td>

                                <td>{{ $p->total_quantity }}</td>

                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>

                                <td>
                                    @if ($p->status_pesanan === 'Pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($p->status_pesanan === 'Dibayar')
                                        <span class="badge bg-success">Dibayar</span>
                                    @elseif ($p->status_pesanan === 'Selesai')
                                        <span class="badge bg-primary">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </td>

                                <td>{{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M Y') }}</td>

                                <td>
                                    <a href="{{ route('admin.pesanan.show', $p->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-muted py-3">
                                    Belum ada pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pesanans->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
