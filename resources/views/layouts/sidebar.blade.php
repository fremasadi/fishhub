<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-fish"></i>
        </div>
        <div class="sidebar-brand-text mx-3">KediriFishHub</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (Auth::check() && Auth::user()->role === 'admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Menu Admin
        </div>

        <!-- Nav Item - Manajemen User -->
        <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Manajemen User</span>
            </a>
        </li>

        <!-- Nav Item - Peternak -->
        <li class="nav-item {{ request()->routeIs('peternaks.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('peternaks.index') }}">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Data Peternak</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Manajemen Data
        </div>

        <!-- Nav Item - Stok Benih -->
        <li class="nav-item {{ request()->routeIs('admin.benih.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.benih.index') }}">
                <i class="fas fa-fw fa-fish"></i>
                <span>Stok Benih</span>
            </a>
        </li>

        {{-- <!-- Nav Item - Pesanan -->
        <li class="nav-item {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pesanan.index') }}">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Pesanan</span>
            </a>
        </li>

        <!-- Nav Item - Pembayaran -->
        <li class="nav-item {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pembayaran.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Pembayaran</span>
            </a>
        </li> --}}
    @endif

    @if (Auth::check() && Auth::user()->role === 'peternak')
        <!-- Heading -->
        <div class="sidebar-heading">
            Menu Peternak
        </div>

        <!-- Nav Item - Stok Benih -->
        {{-- <li class="nav-item {{ request()->routeIs('benih.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('benih.index') }}">
                <i class="fas fa-fw fa-fish"></i>
                <span>Stok</span>
            </a>s
        </li>

        <!-- Nav Item - Pesanan -->
        <li class="nav-item {{ request()->routeIs('peternak.pesanan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('peternak.pesanan.index') }}">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Pesanan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('peternak.pengambilan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('peternak.pengambilan.index') }}">
                <i class="fas fa-box-open"></i>
                <span>Pengambilan</span>
            </a>
        </li>

        <!-- Nav Item - Riwayat Pembayaran -->
        <li class="nav-item {{ request()->routeIs('peternak.pembayaran.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('peternak.pembayaran.index') }}">
                <i class="fas fa-fw fa-credit-card"></i>
                <span>Riwayat Pembayaran</span>
            </a>
        </li> --}}
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
