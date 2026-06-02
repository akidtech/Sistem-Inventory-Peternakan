<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @php $invActive = request()->routeIs('inventory.barang.*', 'inventory.masuk.*', 'inventory.keluar.*'); @endphp
        <li class="nav-item {{ $invActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#menu-inventory">
                <i class="ti-package menu-icon"></i>
                <span class="menu-title">Inventory</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $invActive ? 'show' : '' }}" id="menu-inventory">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('inventory.barang.*') ? 'active' : '' }}"
                            href="{{ route('inventory.barang.index') }}">Data Barang</a>
                    </li>
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('inventory.masuk.*') ? 'active' : '' }}"
                                href="{{ route('inventory.masuk.index') }}">Barang Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('inventory.keluar.*') ? 'active' : '' }}"
                                href="{{ route('inventory.keluar.index') }}">Barang Keluar</a>
                        </li>
                    @endif
                </ul>
            </div>
        </li>

        @if (auth()->user()->isAdmin())
            @php $lapActive = request()->routeIs('laporan.inventory'); @endphp
            <li class="nav-item {{ $lapActive ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#menu-laporan">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Laporan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse {{ $lapActive ? 'show' : '' }}" id="menu-laporan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('laporan.inventory') ? 'active' : '' }}"
                                href="{{ route('laporan.inventory') }}">Laporan Inventory</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if (auth()->user()->isAdmin())
            @php $setActive = request()->routeIs('pengaturan.user', 'pengaturan.user.*'); @endphp
            <li class="nav-item {{ $setActive ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#menu-pengaturan">
                    <i class="ti-settings menu-icon"></i>
                    <span class="menu-title">Pengaturan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse {{ $setActive ? 'show' : '' }}" id="menu-pengaturan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pengaturan.user', 'pengaturan.user.*') ? 'active' : '' }}"
                                href="{{ route('pengaturan.user') }}">Manajemen User</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        <li class="nav-item {{ request()->routeIs('pengaturan.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pengaturan.profile') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Profil Saya</span>
            </a>
        </li>

    </ul>
</nav>
