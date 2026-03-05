@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4">Daftar Pembayaran</h1>

    {{-- Filter --}}
    <div class="card shadow mb-4">
        <div class="card-body py-3">
            <form method="GET" action="" class="row g-2 align-items-end">
                <div class="col-auto">
                    <label class="form-label mb-1 small fw-semibold">Bulan</label>
                    <select name="bulan" class="form-select form-select-sm">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <label class="form-label mb-1 small fw-semibold">Tahun</label>
                    <select name="tahun" class="form-select form-select-sm">
                        <option value="">Semua Tahun</option>
                        @foreach(range(date('Y'), date('Y')-4) as $y)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ request()->url() }}" class="btn btn-secondary btn-sm">Reset</a>
                </div>
                @if(request('bulan') || request('tahun'))
                <div class="col-auto ms-auto text-end">
                    <span class="text-muted small">Subtotal</span><br>
                    <span class="fw-bold text-success fs-6">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Pembeli</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Transaksi</th>
                            <th>Tanggal Settlement</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pembayarans as $pay)
                            <tr>
                                <td>{{ $loop->iteration + ($pembayarans->currentPage() - 1) * $pembayarans->perPage() }}</td>

                                <td>{{ $pay->order_id }}</td>

                                <td>{{ $pay->pesanan->pembudidaya->name ?? '-' }}</td>

                                <td>{{ $pay->payment_method_label }}</td>

                                <td>Rp {{ number_format($pay->gross_amount, 0, ',', '.') }}</td>

                                <td>
                                    <span class="badge bg-{{ $pay->status_badge_class }}">
                                        {{ $pay->status_label }}
                                    </span>
                                </td>

                                <td>
                                    {{ $pay->transaction_time ? $pay->transaction_time->format('d M Y H:i') : '-' }}
                                </td>

                                <td>
                                    {{ $pay->settlement_time ? $pay->settlement_time->format('d M Y H:i') : '-' }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="10" class="text-muted py-3">
                                    Belum ada data pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-semibold">Subtotal:</td>
                            <td class="fw-bold text-success">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3">
                {{ $pembayarans->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
