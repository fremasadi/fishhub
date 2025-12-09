@extends('front.frontapp')

@section('title', 'Pembayaran')

@section('content')

<div class="py-5">
    <div class="container">

        <!-- HEADER STATUS -->
        <div class="text-center mb-5">

            @if($pembayaran->isSuccess())
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-success bg-opacity-25 rounded-circle" style="width:80px; height:80px;">
                    <i class="fa fa-check fa-3x text-success"></i>
                </div>
                <h1 class="fw-bold text-success">Pembayaran Berhasil 🎉</h1>
                <p class="text-muted">Terima kasih, pembayaran Anda telah dikonfirmasi.</p>

            @elseif($pembayaran->isFailed())
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-danger bg-opacity-25 rounded-circle" style="width:80px; height:80px;">
                    <i class="fa fa-times fa-3x text-danger"></i>
                </div>
                <h1 class="fw-bold text-danger">Pembayaran Gagal</h1>
                <p class="text-muted">{{ $pembayaran->getStatusLabel() }}</p>

            @else
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-warning bg-opacity-25 rounded-circle" style="width:80px; height:80px;">
                    <i class="fa fa-clock fa-3x text-warning"></i>
                </div>
                <h1 class="fw-bold text-dark">Menunggu Pembayaran</h1>
                <p class="text-muted">Silakan selesaikan pembayaran untuk melanjutkan pesanan.</p>
            @endif

            <span class="badge bg-{{ $pembayaran->getStatusBadgeClass() }} px-3 py-2 fs-6">
                {{ $pembayaran->getStatusLabel() }}
            </span>
        </div>

        @if(session('success'))
        <div class="alert alert-success d-flex align-items-center">
            <i class="fa fa-check me-2"></i> {{ session('success') }}
        </div>
        @endif

        <div class="row g-4">

            <!-- LEFT CONTENT -->
            <div class="col-lg-8">

                <!-- DETAIL TRANSAKSI -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <h4 class="fw-bold mb-4">
                            <i class="fa fa-file-invoice me-2 text-primary"></i> Detail Transaksi
                        </h4>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Order ID</span>
                                <strong>{{ $pembayaran->order_id }}</strong>
                            </li>

                            @if($pembayaran->transaction_id)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Transaction ID</span>
                                <span>{{ $pembayaran->transaction_id }}</span>
                            </li>
                            @endif

                           

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Metode Pembayaran</span>
                                <strong>
                                    @if($pembayaran->payment_type)
                                        @if($pembayaran->payment_type === 'bank_transfer' && $pembayaran->bank)
                                            {{ strtoupper($pembayaran->bank) }} Virtual Account
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $pembayaran->payment_type)) }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </strong>
                            </li>

                            @if($pembayaran->va_number)
                            <li class="list-group-item">
                                <div class="p-3 bg-light border rounded">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>Virtual Account</strong>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold fs-5 text-primary">{{ $pembayaran->va_number }}</div>
                                            <button class="btn btn-sm btn-link" onclick="copyVA()">📋 Salin</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif


                            @if($pembayaran->settlement_time)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tanggal Pembayaran</span>
                                <strong class="text-success">{{ $pembayaran->settlement_time->format('d M Y H:i') }}</strong>
                            </li>
                            @endif

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fs-4 fw-bold">Total Pembayaran</span>
                                <span class="fs-3 fw-bold text-danger">
                                    Rp {{ number_format($pembayaran->gross_amount, 0, ',', '.') }}
                                </span>
                            </li>
                        </ul>

                    </div>
                </div>

                <!-- LIST KOSTUM -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3"><i class="fa fa-list me-2 text-primary"></i> Daftar Pesanan</h4>

                        @foreach($pesanan->details as $detail)
                        <div class="d-flex justify-content-between align-items-center p-3 border rounded mb-2 bg-light">
                            <div>
                                <div class="fw-bold">{{ $detail->stokBenih->jenis ?? '-' }}</div>
                                <small class="text-muted">
                                    Ukuran: {{ $detail->stokBenih->ukuran ?? '-' }}  
                                    • Jumlah: {{ $detail->qty }}
                                </small>
                            </div>

                            <div class="fw-bold text-danger">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- PAYMENT ACTION -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        @if($pembayaran->isPending())
                            <button id="pay-button" class="btn btn-primary w-100 mb-3 py-3 fw-bold">
                                💳 Bayar Sekarang
                            </button>

                            <button onclick="checkPaymentStatus()" id="checkStatusBtn"
                                class="btn btn-warning w-100 fw-bold">
                                🔄 Cek Status Pembayaran
                            </button>

                            <p class="text-center text-muted small mt-2">
                                Status otomatis diperbarui setiap 30 detik.
                            </p>
                        @endif

                        @if($pembayaran->isSuccess())
                        <div class="alert alert-success text-center">
                            <i class="fa fa-check me-2"></i> Pembayaran telah dikonfirmasi.
                        </div>
                        @endif


                    </div>
                </div>

                @if($pembayaran->isPending())
                <div class="alert alert-warning">
                    <strong>Perhatian:</strong> Selesaikan pembayaran dalam 24 jam atau pesanan otomatis dibatalkan.
                </div>
                @endif
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 80px;">
                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Informasi Penting</h5>

                        <ul class="list-unstyled small">
                            <li class="mb-3">
                                <i class="fa fa-lock text-primary me-2"></i>
                                Pembayaran aman melalui Midtrans.
                            </li>
                            <li class="mb-3">
                                <i class="fa fa-bolt text-warning me-2"></i>
                                Konfirmasi otomatis dalam beberapa menit.
                            </li>
                            <li class="mb-3">
                                <i class="fa fa-credit-card text-success me-2"></i>
                                Mendukung transfer bank & QRIS.
                            </li>
                            <li class="mb-3">
                                <i class="fa fa-info-circle text-primary me-2"></i>
                                Simpan bukti pembayaran Anda.
                            </li>
                        </ul>

                        <div class="p-3 bg-light rounded border">
                            <strong class="text-primary">Tips:</strong>
                            <ul class="small mt-2 mb-0">
                                <li>Selesaikan pembayaran sebelum 24 jam.</li>
                                <li>Simpan bukti transaksi.</li>
                                <li>Periksa status pembayaran secara berkala.</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection

@section('scripts')


<script src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>


document.addEventListener("DOMContentLoaded", function () {
    
    const snapToken = "{{ $pembayaran->payment_url }}";
    
    const payBtn = document.getElementById("pay-button");
    
    if (payBtn) {
        payBtn.addEventListener("click", function () {
            
            if (typeof snap !== 'undefined' && snapToken) {
                snap.pay(snapToken, {
                    onSuccess: () => { console.log("SUCCESS"); location.reload(); },
                    onPending: () => { console.log("PENDING"); location.reload(); },
                    onError: () => { console.log("ERROR"); },
                    onClose: () => { console.log("CLOSED"); }
                });
            } else {
                alert("Snap not ready or token invalid");
            }
        });
    }
});

function checkPaymentStatus() {
    fetch("{{ route('payment.check-status', $pesanan->id) }}")
        .then(r => r.json())
        .then(d => { if (d.is_paid) location.reload(); });
}

function copyVA() {
    navigator.clipboard.writeText("{{ $pembayaran->va_number }}");
    alert('Nomor VA berhasil disalin!');
}
</script>
@endsection

