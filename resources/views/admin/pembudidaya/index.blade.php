@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Daftar Pembudidaya</h1>
        <a href="{{ route('pembudidayas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pembudidaya
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pembudidayas as $pembudidaya)
                            <tr>
                                <td>{{ $loop->iteration + ($pembudidayas->currentPage() - 1) * $pembudidayas->perPage() }}</td>
                                <td>{{ $pembudidaya->user->name }}</td>
                                <td>{{ $pembudidaya->user->email }}</td>
                                <td>{{ $pembudidaya->no_hp }}</td>
                                <td>{{ Str::limit($pembudidaya->alamat, 50) }}</td>

                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('pembudidayas.show', $pembudidaya) }}"
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('pembudidayas.edit', $pembudidaya) }}"
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('pembudidayas.destroy', $pembudidaya) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus pembudidaya ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    Belum ada data pembudidaya
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pembudidayas->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
