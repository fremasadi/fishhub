@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Stok Benih Saya</h1>
            <a href="{{ route('benih.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Stok Benih
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Ukuran</th>
                                <th>Kualitas</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Validasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($benih as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <!-- Foto Benih -->
                                    <td>
                                        @if ($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" class="img-thumbnail"
                                                width="70">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>

                                    <td>{{ $item->jenis }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->ukuran }}</td>
                                    <td>{{ $item->kualitas }}</td>

                                    <!-- Harga -->
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>

                                    <!-- Status -->
                                    <td>
                                        <span
                                            class="badge bg-{{ $item->status_stok == 'Tersedia' ? 'success' : 'secondary' }}">
                                            {{ $item->status_stok }}
                                        </span>
                                    </td>

                                    <!-- Validasi -->
                                    <td>
                                        <span
                                            class="badge bg-{{ $item->status_validasi == 'Terverifikasi' ? 'info' : 'warning' }}">
                                            {{ $item->status_validasi }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('benih.edit', $item) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('benih.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('Hapus data?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">
                                        Belum ada data stok benih
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $benih->links() }}
            </div>
        </div>

    </div>
@endsection
