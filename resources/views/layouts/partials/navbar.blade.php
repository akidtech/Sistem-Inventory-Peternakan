<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="Sumber Makmur"
                style="height: 100px; width: auto; object-fit: contain; ">
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo-mini.png') }}" alt="SM"
                style="height: 100px; width: auto; object-fit: contain;">
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
            {{-- Notifikasi --}}
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                    data-toggle="dropdown">
                    <i class="icon-bell mx-0"></i>
                    @php $notifCount = auth()->user()->notifikasi()->belumDibaca()->count(); @endphp
                    @if ($notifCount > 0)
                        <span class="count bg-danger">{{ $notifCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifikasi</p>
                    @forelse(auth()->user()->notifikasi()->where('sudah_dibaca', false)->latest()->take(5)->get() as $notif)
                        <a class="dropdown-item preview-item" href="#">
                            <div class="preview-thumbnail">
                                <div
                                    class="preview-icon 
                {{ $notif->tipe == 'stok_menipis'
                    ? 'bg-warning'
                    : ($notif->tipe == 'ternak_siap_jual'
                        ? 'bg-success'
                        : 'bg-info') }}">
                                    <i
                                        class="{{ $notif->tipe == 'stok_menipis'
                                            ? 'ti-alert'
                                            : ($notif->tipe == 'ternak_siap_jual'
                                                ? 'ti-star'
                                                : 'ti-package') }} mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">{{ $notif->judul }}</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    {{ Str::limit($notif->pesan, 50) }}
                                </p>
                                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    @empty
                        <a class="dropdown-item text-center text-muted">Tidak ada notifikasi</a>
                    @endforelse
                </div>
            </li>

            {{-- Profile --}}
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    @if (auth()->user()->foto)
                        <img src="{{ asset('uploads/foto/' . auth()->user()->foto) }}" alt="profile"
                            style="width:30px; height:30px; object-fit:cover; border-radius:50%;">
                    @else
                        <div class="d-inline-flex align-items-center justify-content-center"
                            style="width:30px; height:30px; background:#e8f5e9; border-radius:50%; font-size:13px; font-weight:bold; color:#2E7D32;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <div class="dropdown-item" style="cursor: default;">
                        <i class="ti-user text-primary mr-2"></i>
                        <strong>{{ auth()->user()->name }}</strong>
                        <br>
                        <small class="text-muted ml-4">{{ ucfirst(auth()->user()->role) }}</small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <i class="ti-settings text-primary mr-2"></i> Pengaturan
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ti-power-off text-danger mr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
