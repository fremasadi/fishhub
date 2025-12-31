@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4"><i class="fas fa-edit"></i> Edit Stok Benih</h1>

        <div class="card shadow">
            <div class="card-body">

                <form action="{{ route('benih.update', $benih) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- Jenis -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Benih</label>
                            <input type="text" name="jenis" class="form-control" value="{{ $benih->jenis }}" required>
                        </div>

                        <!-- Jumlah -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" value="{{ $benih->jumlah }}" required>
                        </div>

                        <!-- Ukuran -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ukuran</label>
                            <input type="text" name="ukuran" class="form-control" value="{{ $benih->ukuran }}" required>
                        </div>

                        <!-- Kualitas -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kualitas</label>
                            <input type="text" name="kualitas" class="form-control" value="{{ $benih->kualitas }}"
                                required>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" value="{{ $benih->harga }}" required>
                        </div>

                        <!-- Upload gambar baru -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ganti Foto Benih (Opsional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <!-- Preview gambar lama -->
                        @if ($benih->image)
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Foto Saat Ini:</label><br>
                                <img src="{{ asset('storage/' . $benih->image) }}" class="img-thumbnail" width="200">
                            </div>
                        @endif

                    </div>

                    <div class="mt-3">
                        <button class="btn btn-warning">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>

                        <a href="{{ route('benih.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
