@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4">Daftar Stok Benih</h1>

    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Peternak</th>
                            <th>Jenis</th>
                            <th>Ukuran</th>
                            <th>Kualitas</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <!-- <th>Validasi</th> -->
                            <th>Tanggal Input</th>
                            <th>Gambar</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($stok as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($stok->currentPage() - 1) * $stok->perPage() }}</td>

                                <td>{{ $item->peternak->user->name }}</td>

                                <td>{{ $item->jenis }}</td>

                                <td>{{ $item->ukuran }} cm</td>

                                <td>{{ ucfirst($item->kualitas) }}</td>

                                <td>{{ number_format($item->jumlah) }}</td>

                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>

                                <td>
                                    @if ($item->status_stok === 'tersedia')
                                        <span>Tersedia</span>
                                    @else
                                        <span>Habis</span>
                                    @endif
                                </td>

                                <!-- <td>
                                    @if ($item->status_validasi === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($item->status_validasi === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td> -->

                                <td>{{ \Carbon\Carbon::parse($item->tanggal_input)->format('d M Y') }}</td>

                                <td>
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" 
                                             alt="gambar" width="60" height="60"
                                             style="object-fit: cover;" class="rounded">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="11" class="text-muted py-3">
                                    Belum ada data stok benih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $stok->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
