<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">E-NYOBLOS <sup>V2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::currentRouteName() == 'panitia_home' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Panitia
    </div>


    <!-- Nav Item - Kandidat -->
    <li class="nav-item {{ Route::currentRouteName() == 'kandidat.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kandidat.index') }}">
            <i class="fas fa-fw fa-hammer"></i>
            <span>Data Kandidat</span></a>
    </li>

    <!-- Nav Item - Pemilih -->
    <li class="nav-item {{ Route::currentRouteName() == 'pemilih.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pemilih.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Pemilih</span></a>
    </li>

    <!-- Nav Item - Status Pemilihan -->
    <li class="nav-item {{ Route::currentRouteName() == 'status_pemilihan' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('status_pemilihan') }}">
            <i class="fas fa-fw fa-check"></i>
            <span>Status Pemilihan</span></a>
    </li>

    <!-- Nav Item - Master -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Master
    </div>

    @if (Auth::user()->role == 'master')
        <li class="nav-item {{ Route::currentRouteName() == 'panitia.index' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('panitia.index') }}">
                <i class="fas fa-fw fa-lock"></i>
                <span>Data Panitia</span></a>
        </li>
        <li class="nav-item {{ Route::currentRouteName() == 'user.index' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fas fa-fw fa-lock"></i>
                <span>Master User</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Pengaturan
    </div>


    <!-- Nav Item - Pengaturan -->
    <li class="nav-item {{ Route::currentRouteName() == 'pengaturan' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pengaturan') }}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pengaturan KPU</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
