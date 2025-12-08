@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Daftar Peternak</h1>
        <a href="{{ route('peternaks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Peternak
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
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($peternaks as $peternak)
                            <tr>
                                <td>{{ $loop->iteration + ($peternaks->currentPage() - 1) * $peternaks->perPage() }}</td>
                                <td>{{ $peternak->user->name }}</td>
                                <td>{{ $peternak->user->email }}</td>
                                <td>{{ $peternak->no_hp }}</td>
                                <td>{{ Str::limit($peternak->alamat, 50) }}</td>

                                <td>
                                    @if($peternak->status_aktif)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('peternaks.show', $peternak) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('peternaks.edit', $peternak) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('peternaks.destroy', $peternak) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus peternak ini?')">
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
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Belum ada data peternak
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $peternaks->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
