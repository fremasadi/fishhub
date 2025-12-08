@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">
            <i class="fas fa-seedling"></i> Tambah Stok Benih
        </h1>

        <a href="{{ route('benih.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-plus"></i> Form Tambah Stok Benih
            </h6>
        </div>

        <div class="card-body">
            <form action="{{ route('benih.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <!-- Jenis -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Benih</label>
                        <input type="text" name="jenis" class="form-control" placeholder="Contoh: Lele, Nila, Gurame" required>
                    </div>

                    <!-- Jumlah -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah benih" required>
                    </div>

                    <!-- Ukuran -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ukuran</label>
                        <input type="text" name="ukuran" class="form-control" placeholder="Contoh: 3–5 cm, 5–7 cm" required>
                    </div>

                    <!-- Kualitas -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kualitas</label>
                        <input type="text" name="kualitas" class="form-control" placeholder="Contoh: Grade A / B / Bagus" required>
                    </div>

                    <!-- Harga -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 500" required>
                    </div>

                    <!-- Gambar -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto Benih (Opsional)</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>

                    <a href="{{ route('benih.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
