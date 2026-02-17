@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Pembudidaya</h1>
        <a href="{{ route('pembudidayas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- INFORMASI PEMBUDIDAYA --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header font-weight-bold">
                    Informasi Pembudidaya
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="40%">Nama</th>
                            <td>{{ $pembudidaya->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $pembudidaya->user->email }}</td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td>{{ $pembudidaya->no_hp }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $pembudidaya->alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
