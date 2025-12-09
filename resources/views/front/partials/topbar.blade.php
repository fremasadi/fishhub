<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-fish"></i> Benih Ikan
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                {{-- Menu umum --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#stok-benih') }}">
                        <i class="fas fa-box"></i> Stok Benih
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#peta-peternak') }}">
                        <i class="fas fa-map-marked-alt"></i> Peta Peternak
                    </a>
                </li>

                @if (Route::has('login'))
                    @auth

                        {{-- ================= MOBILE VERSION ================= --}}
                        {{-- Keranjang mobile --}}
                        @if(auth()->user()->role === 'pembudidaya')
                            <li class="nav-item d-lg-none">
                                <a class="nav-link" href="{{ route('cart.index') }}">
                                    <i class="fas fa-shopping-cart"></i> Keranjang
                                    @php
                                        $cart = Session::get('cart', []);
                                        $cartCount = count($cart);
                                    @endphp
                                    @if($cartCount > 0)
                                        <span class="badge bg-danger">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif

                        {{-- History mobile --}}
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="{{ route('payment.history') }}">
                                <i class="fas fa-history"></i> History
                            </a>
                        </li>

                        {{-- Logout mobile --}}
                        <li class="nav-item d-lg-none">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="nav-link text-danger border-0 bg-transparent">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>

                        {{-- ================= DESKTOP VERSION ================= --}}
                        <li class="nav-item dropdown ms-3 d-none d-lg-block">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                        class="rounded-circle" width="36" height="36" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                        style="width: 25px; height: 25px; font-size: 14px;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">

                                {{-- Keranjang desktop --}}
                                @if(auth()->user()->role === 'pembudidaya')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cart.index') }}">
                                            <i class="fas fa-shopping-cart me-2"></i> Keranjang
                                            @if($cartCount > 0)
                                                <span class="badge bg-danger">{{ $cartCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- History desktop --}}
                                <li>
                                    <a class="dropdown-item" href="{{ route('payment.history') }}">
                                        <i class="fas fa-history me-2"></i> History
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                                {{-- Logout --}}
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @else
                        {{-- Belum login --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-light text-primary px-3 ms-2" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Register
                                </a>
                            </li>
                        @endif
                    @endauth
                @endif

            </ul>
        </div>
    </div>
</nav>

<style>
.cart-badge {
    font-size: 0.65rem;
    padding: 0.25em 0.5em;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: translate(-50%, -50%) scale(1); }
    50% { transform: translate(-50%, -50%) scale(1.1); }
    100% { transform: translate(-50%, -50%) scale(1); }
}

.nav-link:hover .fa-shopping-cart {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}

@media (max-width: 991px) {
    .cart-badge {
        font-size: 0.6rem;
    }
}
</style>
