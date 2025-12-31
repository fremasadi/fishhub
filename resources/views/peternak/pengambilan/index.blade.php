@extends('layouts.app')

@section('title', 'Data Pengambilan')

@section('content')
    <div class="container-fluid">

        <h4 class="mb-4 fw-bold">📦 Data Pengambilan Benih</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body table-responsive">

                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kode Pesanan</th>
                            <th>Pembudidaya</th>
                            <th>Tanggal</th>
                            <th>Status Pengambilan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengambilans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $item->pesanan->id }}</td>
                                <td>{{ $item->pesanan->pembudidaya->name }}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <span
                                        class="badge
                                    @if ($item->status_pengambilan === 'Menunggu') bg-warning
                                    @elseif($item->status_pengambilan === 'Siap Diambil') bg-info
                                    @elseif($item->status_pengambilan === 'Diterima') bg-success
                                    @else bg-secondary @endif
                                ">
                                        {{ $item->status_pengambilan }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('peternak.pengambilan.show', $item->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data pengambilan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $pengambilans->links() }}

            </div>
        </div>

    </div>
@endsection
