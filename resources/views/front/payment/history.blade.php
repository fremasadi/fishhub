@extends('front.frontapp')

@section('title', 'Riwayat Pesanan')

@section('content')

    <div class="py-5">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- HEADER -->
            <div class="mb-5">
                <h1 class="fw-bold mb-2">
                    <i class="fas fa-history text-primary"></i> Riwayat Pesanan
                </h1>
                <p class="text-muted">Lihat semua pesanan yang pernah Anda buat</p>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('payment.history') }}" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" class="form-control"
                                value="{{ request('tanggal_awal') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control"
                                value="{{ request('tanggal_akhir') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="{{ route('payment.history') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @if ($pesanans->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Peternak</th>
                                        <th>Item Pesanan</th>
                                        <th>Status Bayar</th>
                                        <th>Status Terima</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanans as $pesanan)
                                        @php
                                            $pembayaran = $pesanan->pembayaran;
                                            $status = $pesanan->pengambilan?->status_pengambilan;
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
                                        <tr>
                                            <td>{{ $loop->iteration + ($pesanans->currentPage() - 1) * $pesanans->perPage() }}</td>
                                            <td class="fw-bold">
                                                {{ $pembayaran->order_id ?? 'Order #' . $pesanan->id }}
                                            </td>
                                            <td>
                                                {{ $pesanan->created_at->format('d M Y') }}
                                                <small class="text-muted d-block">{{ $pesanan->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>{{ $pesanan->peternak->user->name ?? 'N/A' }}</td>
                                            <td>
                                                @foreach ($pesanan->details as $detail)
                                                    <div class="mb-1">
                                                        <span class="fw-semibold">{{ $detail->stokBenih->jenis ?? 'N/A' }}</span>
                                                        <small class="text-muted d-block">
                                                            {{ $detail->stokBenih->ukuran ?? '-' }} | Qty: {{ number_format($detail->qty) }}
                                                        </small>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($pembayaran)
                                                    <span class="badge bg-{{ $pembayaran->getStatusBadgeClass() }}">
                                                        {{ $pembayaran->getStatusLabel() }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">No Payment Data</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($pesanan->pembayaran?->isSuccess() && $pesanan->pengambilan)
                                                    <span class="badge {{ $statusClass }}">
                                                        {{ $statusLabel }}
                                                    </span>

                                                    @if($pesanan->status_pesanan === 'Selesai')
                                                        <span class="badge bg-primary mt-1">
                                                            <i class="fas fa-check-double me-1"></i> Selesai
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold text-danger">
                                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-1 align-items-stretch">
                                                    <a href="{{ route('payment.show', $pesanan->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-eye me-1"></i> Detail
                                                    </a>
                                                    @if ($pesanan->pembayaran && $pesanan->pembayaran->isSuccess() && $pesanan->pengambilan)
                                                        <button type="button" class="btn btn-outline-success btn-sm"
                                                            onclick="openPengambilan({{ $pesanan->id }})">
                                                            <i class="fas fa-box me-1"></i> Penerimaan
                                                        </button>
                                                    @endif

                                                    @if(
                                                        $pesanan->pengambilan &&
                                                        $pesanan->pengambilan->status_pengambilan === 'Diterima'
                                                    )
                                                        @if($pesanan->review)
                                                            <button type="button" class="btn btn-outline-warning btn-sm" disabled>
                                                                <i class="fas fa-star me-1"></i> Sudah Direview
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                                onclick="openReview({{ $pesanan->id }})">
                                                                <i class="fas fa-star me-1"></i> Review
                                                            </button>
                                                        @endif
                                                    @endif

                                                    @if(
                                                        $pesanan->pengambilan &&
                                                        $pesanan->pengambilan->status_pengambilan === 'Diterima' &&
                                                        $pesanan->status_pesanan !== 'Selesai'
                                                    )
                                                        <form action="{{ route('payment.selesai', $pesanan->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-primary btn-sm w-100"
                                                                onclick="return confirm('Konfirmasi pesanan ini sudah selesai?')">
                                                                <i class="fas fa-check-double me-1"></i> Selesai
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
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
                    @foreach ($pesanans as $pesanan)
                        @if (
                            $pesanan->pengambilan &&
                            $pesanan->pengambilan->status_pengambilan === 'Diterima' &&
                            !$pesanan->review
                        )
                            <div class="modal fade" id="reviewModal-{{ $pesanan->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('payment.review', $pesanan->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-star text-warning me-2"></i> Review Pesanan
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block mb-1">Peternak</small>
                                                    <strong>{{ $pesanan->peternak->user->name ?? '-' }}</strong>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="rating-{{ $pesanan->id }}" class="form-label fw-semibold">
                                                        Rating
                                                    </label>
                                                    <select id="rating-{{ $pesanan->id }}" name="rating" class="form-control" required>
                                                        <option value="">Pilih rating</option>
                                                        <option value="5">5 - Sangat Baik</option>
                                                        <option value="4">4 - Baik</option>
                                                        <option value="3">3 - Cukup</option>
                                                        <option value="2">2 - Kurang</option>
                                                        <option value="1">1 - Buruk</option>
                                                    </select>
                                                </div>

                                                <div class="mb-0">
                                                    <label for="komentar-{{ $pesanan->id }}" class="form-label fw-semibold">
                                                        Komentar
                                                    </label>
                                                    <textarea id="komentar-{{ $pesanan->id }}" name="komentar"
                                                        class="form-control" rows="4"
                                                        placeholder="Tulis pengalaman Anda menerima benih..."></textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-paper-plane me-1"></i> Kirim Review
                                                </button>
                                            </div>
                                        </form>
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

        function openReview(id) {
            const modalEl = document.getElementById('reviewModal-' + id);

            if (!modalEl) {
                console.error('Modal review tidak ditemukan untuk ID:', id);
                return;
            }

            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    </script>


@endsection
