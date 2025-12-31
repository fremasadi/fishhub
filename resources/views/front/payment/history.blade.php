@extends('front.frontapp')

@section('title', 'Riwayat Pesanan')

@section('content')

    <div class="py-5">
        <div class="container">

            <!-- HEADER -->
            <div class="mb-5">
                <h1 class="fw-bold mb-2">
                    <i class="fas fa-history text-primary"></i> Riwayat Pesanan
                </h1>
                <p class="text-muted">Lihat semua pesanan yang pernah Anda buat</p>
            </div>

            @if ($pesanans->count() > 0)
                <div class="row g-4">
                    @foreach ($pesanans as $pesanan)
                        @php
                            $pembayaran = $pesanan->pembayaran;
                        @endphp

                        <div class="col-12">
                            <div class="card shadow-sm hover-card">
                                <div class="card-body">

                                    <!-- HEADER CARD -->
                                    <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">

                                        {{-- KIRI --}}
                                        <div>
                                            <h5 class="fw-bold mb-1">
                                                {{ $pembayaran->order_id ?? 'Order #' . $pesanan->id }}
                                            </h5>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $pesanan->created_at->format('d M Y, H:i') }}
                                            </small>
                                        </div>

                                        {{-- KANAN --}}
                                        <div class="d-flex flex-column align-items-end gap-1">

                                            @if ($pembayaran)
                                                {{-- STATUS PEMBAYARAN --}}
                                                <span class="badge bg-{{ $pembayaran->getStatusBadgeClass() }} px-3 py-2">
                                                    {{ $pembayaran->getStatusLabel() }}
                                                </span>

                                                {{-- STATUS PENGAMBILAN --}}
                                                @if ($pesanan->pembayaran->isSuccess() && $pesanan->pengambilan)
                                                    @php
                                                        $status = $pesanan->pengambilan->status_pengambilan;

                                                        $statusLabel = match ($status) {
                                                            'Menunggu' => 'Menunggu Diambil',
                                                            'Siap Diambil' => 'Siap Diambil Pembudidaya',
                                                            'Diterima' => 'Benih Telah Diterima',
                                                            default => $status,
                                                        };

                                                        $statusClass = match ($status) {
                                                            'Menunggu' => 'bg-warning',
                                                            'Siap Diambil' => 'bg-info',
                                                            'Diterima' => 'bg-success',
                                                            default => 'bg-secondary',
                                                        };
                                                    @endphp

                                                    <span class="badge {{ $statusClass }} px-3 py-2">
                                                        {{ $statusLabel }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary px-3 py-2">
                                                    No Payment Data
                                                </span>
                                            @endif

                                        </div>
                                    </div>

                                    <!-- PETERNAK INFO -->
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Peternak:</small>
                                        <strong>
                                            <i class="fas fa-store text-primary me-1"></i>
                                            {{ $pesanan->peternak->user->name ?? 'N/A' }}
                                        </strong>
                                    </div>

                                    <!-- ITEMS LIST -->
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-2">Item Pesanan:</small>

                                        @foreach ($pesanan->details as $detail)
                                            <div
                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-2">
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold">{{ $detail->stokBenih->jenis ?? 'N/A' }}</div>
                                                    <small class="text-muted">
                                                        Ukuran: {{ $detail->stokBenih->ukuran ?? '-' }}
                                                        | Qty: {{ $detail->qty }}
                                                    </small>
                                                </div>
                                                <div class="text-end">
                                                    <div class="fw-bold text-danger">
                                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- TOTAL & ACTION -->
                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <div>
                                            <small class="text-muted d-block">Total Pembayaran</small>
                                            <h4 class="fw-bold text-danger mb-0">
                                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                            </h4>
                                        </div>

                                        <div>
                                            <a href="{{ route('payment.show', $pesanan->id) }}" class="btn btn-primary">
                                                <i class="fas fa-eye me-2"></i> Lihat Detail
                                            </a>
                                            @if ($pesanan->pembayaran && $pesanan->pembayaran->isSuccess() && $pesanan->pengambilan)
                                                <button type="button" class="btn btn-outline-success btn-sm"
                                                    onclick="openPengambilan({{ $pesanan->id }})">
                                                    <i class="fas fa-box me-1"></i>
                                                    Lihat Detail Penerimaan
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($pesanans as $pesanan)
                        @if ($pesanan->pengambilan)
                            <div class="modal fade" id="pengambilanModal-{{ $pesanan->id }}" tabindex="-1"
                                aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        {{-- HEADER --}}
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-box me-2"></i> Detail Pengambilan Benih
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        {{-- BODY --}}
                                        <div class="modal-body">
                                            <table class="table table-borderless mb-3">
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        @php
                                                            $status = $pesanan->pengambilan->status_pengambilan;
                                                            $label = match ($status) {
                                                                'Menunggu' => 'Menunggu Diambil',
                                                                'Siap Diambil' => 'Siap Diambil Pembudidaya',
                                                                'Diterima' => 'Benih Telah Diterima',
                                                                default => $status,
                                                            };

                                                            $badgeClass = match ($status) {
                                                                'Menunggu' => 'bg-warning',
                                                                'Siap Diambil' => 'bg-info',
                                                                'Diterima' => 'bg-success',
                                                                default => 'bg-secondary',
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Peternak</th>
                                                    <td>{{ $pesanan->peternak->user->name ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Alamat</th>
                                                    <td>{{ $pesanan->peternak->alamat ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Tanggal Pengambilan</th>
                                                    <td>
                                                        {{ $pesanan->pengambilan->tanggal_pengambilan
                                                            ? \Carbon\Carbon::parse($pesanan->pengambilan->tanggal_pengambilan)->format('d M Y H:i')
                                                            : '-' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Catatan</th>
                                                    <td>{{ $pesanan->pengambilan->catatan ?? '-' }}</td>
                                                </tr>
                                            </table>

                                            {{-- BUKTI SERAH --}}
                                            <div>
                                                <h6 class="fw-bold mb-2">
                                                    <i class="fas fa-camera me-1"></i> Bukti Serah Terima
                                                </h6>

                                                @if ($pesanan->pengambilan->bukti_serah)
                                                    <a href="{{ asset('storage/' . $pesanan->pengambilan->bukti_serah) }}"
                                                        target="_blank" class="d-inline-block">

                                                        <img src="{{ asset('storage/' . $pesanan->pengambilan->bukti_serah) }}"
                                                            alt="Bukti Serah" class="img-fluid rounded shadow-sm"
                                                            style="max-height: 220px; object-fit: cover;">
                                                    </a>

                                                    <small class="text-muted d-block mt-1">
                                                        Klik gambar untuk melihat ukuran penuh
                                                    </small>
                                                @else
                                                    <div class="alert alert-secondary mb-0">
                                                        <i class="fas fa-image me-1"></i>
                                                        Bukti serah belum diunggah
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- FOOTER --}}
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="mt-4">
                    {{ $pesanans->links() }}
                </div>
            @else
                <!-- EMPTY STATE -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-inbox fa-5x text-muted opacity-25"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Belum Ada Pesanan</h4>
                    <p class="text-muted mb-4">Anda belum pernah melakukan pemesanan</p>
                    <a href="{{ url('/#stok-benih') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i> Mulai Belanja
                    </a>
                </div>
            @endif

        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.25) !important;
        }
    </style>

    <script>
        function openPengambilan(id) {
            const modalEl = document.getElementById('pengambilanModal-' + id);

            if (!modalEl) {
                console.error('Modal tidak ditemukan untuk ID:', id);
                return;
            }

            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    </script>


@endsection
