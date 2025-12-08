<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-fish"></i>
        </div>
        <div class="sidebar-brand-text mx-3">KediriFishHub</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    @if (Auth::check() && Auth::user()->role === 'admin')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-users"></i>
                <span>Manajemen User</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('peternaks.index') }}">
                <i class="fas fa-database"></i>
                <span>Peternak</span>
            </a>
        </li>
    @endif

    @if (Auth::check() && Auth::user()->role === 'peternak')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('benih.index') }}">
                <i class="fas fa-database"></i>
                <span>Stok Benih</span>
            </a>
        </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">

</ul>
