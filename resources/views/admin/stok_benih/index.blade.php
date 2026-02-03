@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4">Daftar Data Benih Peternak</h1>

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
                                    <td>{{ $item->status_stok === 'Tersedia' ? 'Tersedia' : 'Habis' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_input)->format('d M Y') }}</td>

                                    <td>
                                        @if ($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" width="60" height="60"
                                                class="rounded shadow-sm" style="object-fit: cover; cursor:pointer"
                                                data-toggle="modal" data-target="#imageModal-{{ $item->id }}">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-muted py-3">
                                        Belum ada data stok peternak
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @foreach ($stok as $item)
                        @if ($item->image)
                            <div class="modal fade" id="imageModal-{{ $item->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Gambar Stok Benih</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body text-center">
                                            <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{ $stok->links() }}

            </div>
        </div>

    </div>
@endsection
