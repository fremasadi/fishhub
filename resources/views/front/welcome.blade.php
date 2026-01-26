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
    </style>
@endsection

@section('content')

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
                        Aplikasi resmi dari <strong>Dinas Perikanan Kabupaten Kediri</strong> yang menghadirkan kemudahan
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
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="stok_benih_id" value="{{ $stok->id }}">
                                            <input type="hidden" name="peternak_id" value="{{ $stok->peternak_id }}">
                                            <input type="hidden" name="jumlah" value="100">

                                            <button type="submit" class="btn btn-primary w-100">
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
@endsection

@section('scripts')
    @parent

    <script>
        let map;

        function initMap() {
            const centerKediri = {
                lat: -7.8166,
                lng: 112.0115
            };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 9,
                center: centerKediri,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: true,
            });

            const peternakData = @json($peternaks);
            const bounds = new google.maps.LatLngBounds();

            peternakData.forEach(peternak => {
                if (peternak.latitude && peternak.longitude) {
                    const position = {
                        lat: parseFloat(peternak.latitude),
                        lng: parseFloat(peternak.longitude),
                    };

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
                        <div style="min-width:200px">
                            <h6 class="fw-bold mb-1">${peternak.user.name}</h6>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-map-marker-alt"></i> ${peternak.alamat ?? '-'}
                            </p>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-phone"></i> ${peternak.no_hp ?? '-'}
                            </p>
                            <span class="badge ${peternak.status_aktif ? 'bg-success' : 'bg-secondary'}">
                                ${peternak.status_aktif ? 'Aktif' : 'Tidak Aktif'}
                            </span>
                        </div>
                    `
                    });

                    marker.addListener("click", () => {
                        infoWindow.open(map, marker);
                    });

                    bounds.extend(position);
                }
            });

            if (!bounds.isEmpty()) {
                map.fitBounds(bounds);
            }
        }

        // auto dismiss alert
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
