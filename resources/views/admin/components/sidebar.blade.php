<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">CV LUMINTU</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Admin
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ Route::is('product') || Route::is('product.addproduct') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('product')}}">
            <i class="fas fa-fw fa-gas-pump"></i>
            <span>Produk</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('pembelian') || request()->routeIs('pembelian.add-pembelian') || request()->routeIs('penjualan') || request()->routeIs('laba') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="false" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-book"></i>

            <span>Laporan</span>
        </a>
        <div id="collapseTwo" class="collapse {{ request()->routeIs('pembelian')  || request()->routeIs('pembelian.add-pembelian') || request()->routeIs('penjualan') || request()->routeIs('laba') ? 'show' : '' }}">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Laporan:</h6>
                <a class="collapse-item {{ request()->routeIs('pembelian') ||  request()->routeIs('pembelian.add-pembelian') ? 'active' : '' }}" href="{{ route('pembelian') }}">Laporan Pembelian</a>
                <a class="collapse-item {{ request()->routeIs('penjualan') ? 'active' : '' }}" href="{{ route('penjualan') }}">Laporan Penjualan</a>
                <a class="collapse-item {{ request()->routeIs('laba') ? 'active' : '' }}" href="{{ route('laba') }}">Laporan Laba</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{request()->routeIs('surat-tugas') || request()->routeIs('surat-tugas.add-surat') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTree"
            aria-expanded="false"  aria-controls="collapseTree">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Administrasi</span>
        </a>
        <div id="collapseTree" class="collapse {{request()->routeIs('surat-tugas') || request()->routeIs('surat-tugas.add-surat') ? 'show' : '' }}" 
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Administrasi:</h6>
                <a class="collapse-item {{request()->routeIs('surat-tugas') || request()->routeIs('surat-tugas.add-surat') ? 'active' : '' }}" href="{{route('surat-tugas')}}">Surat Tugas</a>
                <a class="collapse-item" href="utilities-border.html">Surat Jalan</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->