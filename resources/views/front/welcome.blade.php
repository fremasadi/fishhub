@extends('front.frontapp')

@section('title', 'Beranda - Pemesanan Benih Ikan')

@section('styles')
    <style>
        .hero-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 100px 0 80px;
            margin-bottom: 50px;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-blue);
            margin-bottom: 1rem;
        }

        .stock-card {
            height: 100%;
            transition: transform 0.2s;
        }

        .stock-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .stock-image {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        #map {
            height: 500px;
            width: 100%;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .stat-card {
            background: white;
            border-left: 4px solid var(--primary-blue);
        }

        .price-tag {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--success);
        }

        .min-order-badge {
            background: #ffc107;
            color: #000;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 600;
        }

        .review-rating-btn {
            border: 0;
            background: transparent;
            padding: 0;
            color: #ffc107;
            font-weight: 700;
            text-align: left;
        }

        .review-rating-btn:hover {
            color: #e0a800;
            text-decoration: underline;
        }

        .review-star-muted {
            color: #d1d5db;
        }
    </style>
@endsection

@section('content')

@php
    $cartSession = session('cart', []);
    $cartPeternakId = !empty($cartSession) ? reset($cartSession)['peternak_id'] : null;
    $cartPeternakName = !empty($cartSession) ? reset($cartSession)['peternak_name'] : null;
@endphp

    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="container mt-3">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {!! session('warning') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="hero-section my-5 py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="hero-title">Pesan Benih Ikan Berkualitas untuk Budidaya Anda</h1>
                    <p class="hero-subtitle">
                        Aplikasi resmi dari <strong>Perikanan Kabupaten Kediri</strong> yang menghadirkan kemudahan
                        bagi masyarakat
                        dalam mendapatkan benih ikan unggul secara langsung dari peternak lokal yang terverifikasi.
                    </p>
                    <p class="hero-subtitle mt-3">
                        Temukan berbagai jenis benih ikan berkualitas, cek ketersediaan stok secara real-time,
                        dan akses informasi lokasi peternak dengan mudah.
                    </p>

                    <div class="mt-4">
                        <a href="#stok-benih" class="btn btn-light btn-lg px-4 me-3">
                            <i class="fas fa-box"></i> Lihat Stok
                        </a>
                        <a href="#peta-peternak" class="btn btn-outline-dark btn-lg px-4">
                            <i class="fas fa-map-marked-alt"></i> Peta Peternak
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <i class="fas fa-fish fa-10x" style="opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container mb-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h4 class="fw-bold">Benih Berkualitas</h4>
                        <p class="text-muted">Benih ikan dengan kualitas terjamin dan sudah tervalidasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="fw-bold">Peternak Terpercaya</h4>
                        <p class="text-muted">Bermitra dengan peternak berpengalaman dan profesional</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4 class="fw-bold">Pengiriman Cepat</h4>
                        <p class="text-muted">Proses pemesanan mudah dan pengiriman yang aman</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stok Benih Section -->
    <section id="stok-benih" class="container mb-5">
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <form method="GET" action="{{ route('welcome') }}">
                    <div class="input-group">
                        <select name="jenis" class="form-control">
                            <option value="">Semua Jenis Ikan</option>
                            <option value="Ikan Lele" {{ request('jenis') == 'Ikan Lele' ? 'selected' : '' }}>Ikan Lele</option>
                            <option value="Ikan Nila" {{ request('jenis') == 'Ikan Nila' ? 'selected' : '' }}>Ikan Nila</option>
                            <option value="Ikan Mujair" {{ request('jenis') == 'Ikan Mujair' ? 'selected' : '' }}>Ikan Mujair</option>
                            <option value="Ikan Gurame" {{ request('jenis') == 'Ikan Gurame' ? 'selected' : '' }}>Ikan Gurame</option>
                            <option value="Ikan Patin" {{ request('jenis') == 'Ikan Patin' ? 'selected' : '' }}>Ikan Patin</option>
                            <option value="Ikan Mas" {{ request('jenis') == 'Ikan Mas' ? 'selected' : '' }}>Ikan Mas</option>
                            <option value="Ikan Bawal Air Tawar"
                                {{ request('jenis') == 'Ikan Bawal Air Tawar' ? 'selected' : '' }}>
                                Ikan Bawal Air Tawar
                            </option>
                        </select>

                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>

                        <a href="{{ route('welcome') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--primary-blue);">
                <i class="fas fa-box"></i> Stok Benih Tersedia
            </h2>
            <p class="text-muted">Pilih benih ikan berkualitas sesuai kebutuhan Anda</p>
            <p class="text-warning fw-bold">
                <i class="fas fa-info-circle"></i> Minimal pemesanan: 100 ekor per jenis benih
            </p>
        </div>

        <div class="row">
            @forelse($stokBenihs as $stok)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card stock-card">
                        @if ($stok->image)
                            <img src="{{ asset('storage/' . $stok->image) }}" class="stock-image" alt="{{ $stok->jenis }}">
                        @else
                            <div class="stock-image bg-secondary d-flex align-items-center justify-content-center">
                                <i class="fas fa-fish fa-4x text-white"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $stok->jenis }}</h5>

                            <div class="mb-2">
                                <span class="badge badge-primary">{{ $stok->ukuran }}</span>
                                <span class="badge badge-success">{{ $stok->kualitas }}</span>
                            </div>

                            <p class="mb-1 text-muted">
                                <i class="fas fa-user"></i> {{ $stok->peternak->user->name }}
                            </p>
                            @php
                                $peternakReviews = $stok->peternak->reviews ?? collect();
                                $averageRating = $peternakReviews->avg('rating');
                                $roundedRating = $averageRating ? round($averageRating) : 0;
                            @endphp
                            <div class="mb-2">
                                @if($peternakReviews->count() > 0)
                                    <button type="button" class="review-rating-btn small"
                                            onclick="openReviewModal({{ $stok->peternak->id }})">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $roundedRating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                        <span class="text-muted ms-1">
                                            {{ number_format($averageRating, 1) }} ({{ $peternakReviews->count() }} review)
                                        </span>
                                    </button>
                                @else
                                    <small class="text-muted">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star review-star-muted"></i>
                                        @endfor
                                        Belum ada review
                                    </small>
                                @endif
                            </div>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-box"></i> Stok: {{ number_format($stok->jumlah) }} ekor
                            </p>

                            <div class="price-tag mt-3 mb-2">
                                Rp {{ number_format($stok->harga, 0, ',', '.') }}
                                <small class="text-muted" style="font-size: 0.8rem;">/ekor</small>
                            </div>

                            <div class="mb-2">
                                <span class="min-order-badge">
                                    <i class="fas fa-shopping-basket"></i> Min. Order: 100 ekor
                                </span>
                            </div>

                            @if ($stok->status_stok === 'Tersedia')
                                <span class="badge bg-success w-100 mb-2">
                                    <i class="fas fa-check-circle"></i> Tersedia
                                </span>
                            @else
                                <span class="badge bg-warning w-100 mb-2">
                                    <i class="fas fa-clock"></i> Habis
                                </span>
                            @endif

                            @auth
                                @if (auth()->user()->role === 'pembudidaya')
                                    @if ($stok->status_stok === 'Tersedia' && $stok->jumlah >= 100)
                                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="stok_benih_id" value="{{ $stok->id }}">
                                            <input type="hidden" name="peternak_id" value="{{ $stok->peternak_id }}">
                                            <input type="hidden" name="jumlah" value="100">

                                            <button type="submit" class="btn btn-primary w-100"
                                                    data-peternak-id="{{ $stok->peternak_id }}"
                                                    data-peternak-name="{{ $stok->peternak->user->name }}">
                                                <i class="fas fa-cart-plus"></i> Tambah 100 ekor
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="fas fa-ban"></i> Stok Tidak Cukup
                                        </button>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-sign-in-alt"></i> Login untuk Pesan
                                </a>
                            @endauth

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> Belum ada stok benih tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Peta Peternak Section -->
    <section id="peta-peternak" class="container mb-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--primary-blue);">
                <i class="fas fa-map-marked-alt"></i> Peta Lokasi Peternak
            </h2>
            <p class="text-muted">Temukan peternak terdekat di sekitar Anda</p>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <label for="filter-peternak-map" class="form-label fw-semibold">
                    <i class="fas fa-filter"></i> Filter Peternak
                </label>
                <select id="filter-peternak-map" class="form-control" onchange="filterPeternakMap(this.value)">
                    <option value="">Semua Peternak</option>
                    @foreach($peternaks as $peternak)
                        <option value="{{ $peternak->id }}">{{ $peternak->user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div id="map"></div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="container mb-5">
        <div class="card"
            style="background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);">
            <div class="card-body text-center text-white py-5">
                <h2 class="fw-bold mb-3">Siap Memulai Budidaya Ikan?</h2>
                <p class="lead mb-4">Daftar sekarang dan dapatkan benih ikan berkualitas untuk bisnis Anda</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </a>
                @else
                    <a href="#stok-benih" class="btn btn-light btn-lg px-5">
                        <i class="fas fa-tachometer-alt"></i> Stok Benih
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Modal Konfirmasi Ganti Peternak -->
<div class="modal fade" id="modalGantiPeternak" tabindex="-1" aria-labelledby="modalGantiPeternakLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalGantiPeternakLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Ganti Peternak?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <p class="mb-2">Keranjang Anda saat ini berisi item dari peternak:</p>
                    <p class="fw-bold mb-2" id="currentPeternakName"></p>
                    <p class="mb-2">Jika Anda melanjutkan, keranjang akan dikosongkan dan diganti dengan item dari peternak:</p>
                    <p class="fw-bold mb-0" id="newPeternakName"></p>
                </div>
                <p class="text-muted small mb-0">Sistem hanya mendukung pemesanan dari satu peternak dalam satu waktu.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-warning" id="btnKonfirmasiGanti">
                    <i class="fas fa-check"></i> Ya, Ganti Peternak
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Review Peternak -->
@foreach($stokBenihs->pluck('peternak')->filter()->unique('id') as $peternakReview)
    @if($peternakReview->reviews->count() > 0)
        <div class="modal fade" id="reviewModal-{{ $peternakReview->id }}" tabindex="-1"
             aria-labelledby="reviewModalLabel-{{ $peternakReview->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title fw-bold" id="reviewModalLabel-{{ $peternakReview->id }}">
                                <i class="fas fa-star text-warning"></i> Review {{ $peternakReview->user->name }}
                            </h5>
                            <small class="text-muted">
                                Rata-rata {{ number_format($peternakReview->reviews->avg('rating'), 1) }}
                                dari {{ $peternakReview->reviews->count() }} review
                            </small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach($peternakReview->reviews->sortByDesc('created_at') as $review)
                            <div class="border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                    <div>
                                        <strong>{{ $review->pembudidaya->name ?? 'Pembudidaya' }}</strong>
                                        <small class="text-muted d-block">
                                            {{ $review->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                    <div class="text-warning text-nowrap">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-0 text-muted">
                                    {{ $review->komentar ?: 'Tidak ada komentar.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection

@section('scripts')
    @parent

    <script>
        // Konfirmasi ganti peternak
        const cartPeternakId = @json($cartPeternakId);
        const cartPeternakName = @json($cartPeternakName);
        let pendingForm = null;

        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const btn = form.querySelector('button[data-peternak-id]');
                const newPeternakId = parseInt(btn.dataset.peternakId);
                const newPeternakName = btn.dataset.peternakName;

                if (cartPeternakId && cartPeternakId != newPeternakId) {
                    e.preventDefault();
                    pendingForm = form;
                    document.getElementById('currentPeternakName').textContent = cartPeternakName;
                    document.getElementById('newPeternakName').textContent = newPeternakName;
                    new bootstrap.Modal(document.getElementById('modalGantiPeternak')).show();
                }
            });
        });

        document.getElementById('btnKonfirmasiGanti').addEventListener('click', function() {
            if (pendingForm) {
                pendingForm.submit();
            }
        });

        function openReviewModal(peternakId) {
            const modalEl = document.getElementById('reviewModal-' + peternakId);

            if (!modalEl) {
                return;
            }

            new bootstrap.Modal(modalEl).show();
        }

        let map;
        const peternakMarkers = [];

        function escapeHtml(value) {
            return String(value ?? '-')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatRupiah(value) {
            return 'Rp ' + Number(value ?? 0).toLocaleString('id-ID');
        }

        function renderStokBenihList(stokBenihs) {
            if (!stokBenihs || stokBenihs.length === 0) {
                return `
                    <div class="alert alert-warning py-2 px-3 mb-0 small">
                        Belum ada benih tersedia.
                    </div>
                `;
            }

            return `
                <div class="mt-2 pt-2 border-top">
                    <p class="fw-bold small mb-2">
                        <i class="fas fa-fish"></i> Benih yang dijual
                    </p>
                    <div style="max-height:180px; overflow-y:auto;">
                        ${stokBenihs.map(stok => `
                            <div class="border rounded p-2 mb-2">
                                <div class="fw-bold small">${escapeHtml(stok.jenis)}</div>
                                <div class="small text-muted">
                                    ${escapeHtml(stok.ukuran)} | ${escapeHtml(stok.kualitas)}
                                </div>
                                <div class="small">
                                    <i class="fas fa-box"></i> ${Number(stok.jumlah ?? 0).toLocaleString('id-ID')} ekor
                                </div>
                                <div class="small text-success fw-bold">
                                    ${formatRupiah(stok.harga)} / ekor
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        function setMapBoundsByMarkers(markers) {
            const visibleMarkers = markers.filter(marker => marker.getVisible());

            if (visibleMarkers.length === 0) {
                map.setCenter({ lat: -7.8166, lng: 112.0115 });
                map.setZoom(10);
                return;
            }

            const bounds = new google.maps.LatLngBounds();
            visibleMarkers.forEach(marker => bounds.extend(marker.getPosition()));

            if (visibleMarkers.length === 1) {
                map.setCenter(visibleMarkers[0].getPosition());
                map.setZoom(14);
            } else {
                map.fitBounds(bounds);
            }
        }

        function filterPeternakMap(peternakId) {
            peternakMarkers.forEach(({ marker, peternak }) => {
                marker.setVisible(!peternakId || String(peternak.id) === String(peternakId));
            });

            setMapBoundsByMarkers(peternakMarkers.map(item => item.marker));
        }

        function initMap() {
            const centerKediri = {
                lat: -7.8166,
                lng: 112.0115
            };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 10,
                center: centerKediri,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: true,
            });

            // BATAS AREA KEDIRI
            const kediriBoundsArea = {
                minLat: -8.20,
                maxLat: -7.50,
                minLng: 111.80,
                maxLng: 112.40
            };

            const peternakData = @json($peternaks);
            const bounds = new google.maps.LatLngBounds();

            peternakData.forEach(peternak => {
                if (!peternak.latitude || !peternak.longitude) return;

                const lat = parseFloat(peternak.latitude);
                const lng = parseFloat(peternak.longitude);

                // FILTER AREA KEDIRI
                if (
                    lat < kediriBoundsArea.minLat ||
                    lat > kediriBoundsArea.maxLat ||
                    lng < kediriBoundsArea.minLng ||
                    lng > kediriBoundsArea.maxLng
                ) {
                    return; // di luar Kediri -> abaikan
                }

                const position = { lat, lng };

                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: peternak.user.name,
                    icon: {
                        url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                    },
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                    <div style="min-width:260px; max-width:320px;">
                        <h6 class="fw-bold mb-1">${escapeHtml(peternak.user?.name)}</h6>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-map-marker-alt"></i> ${escapeHtml(peternak.alamat)}
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-phone"></i> ${escapeHtml(peternak.no_hp)}
                        </p>
                        <span class="badge ${peternak.status_aktif ? 'bg-success' : 'bg-secondary'}">
                            ${peternak.status_aktif ? 'Aktif' : 'Tidak Aktif'}
                        </span>
                        ${renderStokBenihList(peternak.stok_benihs)}
                    </div>
                    `
                });

                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });

                peternakMarkers.push({ marker, peternak });
                bounds.extend(position);
            });

            if (!bounds.isEmpty()) {
                map.fitBounds(bounds);
            } else {
                map.setCenter(centerKediri);
            }
        }

        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);
    </script>

    {{-- GOOGLE MAPS API --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8l6eRve8pNpEzOfgosulUBmxD5qFZ370&callback=initMap" async
        defer></script>
@endsection
