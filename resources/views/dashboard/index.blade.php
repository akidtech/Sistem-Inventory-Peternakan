@extends('layouts.app')

@section('title', 'Dashboard')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endpush

@section('content')

    {{-- ── Page Header ───────────────────────────────── --}}
    <div class="row">
        <div class="col-12 mb-4">
            <h3 class="font-weight-bold">Dashboard</h3>
            <h6 class="font-weight-normal text-muted">
                Selamat datang, <strong>{{ auth()->user()->name }}</strong>! 👋
                &nbsp;|&nbsp; {{ now()->translatedFormat('l, d F Y') }}
            </h6>
        </div>
    </div>

    {{-- ── Stat Cards ─────────────────────────────────── --}}
    <div class="row">

        {{-- Total Barang --}}
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Total Barang</p>
                    <p class="fs-30 mb-2">{{ $totalBarang }}</p>
                    <p><i class="ti-package"></i> Item inventory</p>
                </div>
            </div>
        </div>

        {{-- Stok Menipis --}}
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-light-blue">
                <div class="card-body">
                    <p class="mb-4">Stok Menipis</p>
                    <p class="fs-30 mb-2">{{ $stokMenipis }}</p>
                    <p><i class="ti-alert text-warning"></i> Barang perlu restock</p>
                </div>
            </div>
        </div>

        {{-- Nilai Inventory --}}
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Nilai Inventory</p>

                    <p class="fs-30 mb-2">
                        Rp {{ number_format($nilaiInventory ?? 0, 0, ',', '.') }}
                    </p>

                    <p>
                        <i class="ti-wallet"></i>
                        Total aset inventory
                    </p>
                </div>
            </div>
        </div>

        {{-- Notifikasi --}}
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-light-danger">
                <div class="card-body">
                    <p class="mb-4">Notifikasi</p>
                    <p class="fs-30 mb-2">{{ $notifBelumDibaca }}</p>
                    <p><i class="ti-bell"></i> Belum dibaca</p>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Charts Row ──────────────────────────────────── --}}
    <div class="row">

        {{-- Chart: Aktivitas Inventory (Bar) --}}
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Aktivitas Inventory</p>
                    <p class="font-weight-500 text-muted">
                        Frekuensi transaksi barang masuk dan keluar
                    </p>

                    <div style="height:300px;">
                        <canvas id="chart-inventory"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart: Stok Inventory (Doughnut) --}}
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Stok Inventory</p>
                    <p class="font-weight-500 text-muted">Total stok per kategori</p>
                    <canvas id="chart-stok" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- Barang Hampir Habis --}}
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <p class="card-title">
                        Barang Hampir Habis
                    </p>

                    <p class="text-muted">
                        Barang yang perlu segera direstock
                    </p>

                    @forelse($barangMenipis as $barang)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">

                            <div>
                                <strong>
                                    {{ $barang->nama_barang }}
                                </strong>

                                <small class="d-block text-muted">
                                    Minimum:
                                    {{ $barang->stok_minimum }}
                                    {{ $barang->satuan }}
                                </small>
                            </div>

                            <span class="badge badge-warning">
                                {{ $barang->stok }}
                                {{ $barang->satuan }}
                            </span>

                        </div>

                    @empty

                        <div class="text-center py-4">
                            <h5 class="text-success">
                                Semua stok aman ✅
                            </h5>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>

    {{-- ── Tabel & Notifikasi Row ──────────────────────── --}}
    <div class="row">

        {{-- Riwayat Aktivitas Terbaru --}}
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="card-title mb-0">Riwayat Aktivitas Terbaru</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Aktivitas</th>
                                    <th>Detail</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aktivitasTerbaru as $a)
                                    <tr>
                                        <td>
                                            @if ($a['tanggal']->diffInHours(now()) < 24)
                                                {{ $a['tanggal']->diffForHumans() }}
                                            @else
                                                {{ $a['tanggal']->translatedFormat('d F Y, H:i') }}
                                            @endif
                                        </td>

                                        <td>
                                            <strong>{{ $a['aktivitas'] }}</strong>
                                        </td>

                                        <td>{{ $a['detail'] }}</td>

                                        <td>
                                            <span class="badge badge-{{ $a['badge'] }}">
                                                {{ $a['aktivitas'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Belum ada aktivitas
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- Notifikasi --}}
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Notifikasi Terbaru</p>
                    <div class="list-wrapper">
                        <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                            @forelse($notifikasi as $notif)
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <i class="input-helper"></i>
                                            <span
                                                class="{{ $notif->tipe == 'text-success' ? 'text-success' : 'text-warning' }}">
                                                <i
                                                    class="ti-{{ $notif->tipe == 'text-success' ? 'star' : 'alert' }} mr-1"></i>
                                            </span>
                                            {{ $notif->judul }}
                                            <small
                                                class="text-muted d-block">{{ $notif->created_at->diffForHumans() }}</small>
                                        </label>
                                    </div>
                                </li>
                            @empty
                                <li class="text-muted text-center">Tidak ada notifikasi</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

{{-- ── Charts JS ───────────────────────────────────── --}}
@push('js')
    <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
    <script>
        // Data dari Laravel (PHP → JS)
        const inventoryMovement = @json($inventoryMovement);
        const dataStok = @json($stokPerKategori);

        // ── Chart Aktivitas Inventory 7 Hari ─────────
        new Chart(document.getElementById('chart-inventory'), {
            type: 'bar',
            data: {
                labels: inventoryMovement.map(i => i.tanggal),

                datasets: [{
                        label: 'Barang Masuk',
                        data: inventoryMovement.map(i => i.masuk),
                        backgroundColor: '#57B657',
                        borderRadius: 6
                    },
                    {
                        label: 'Barang Keluar',
                        data: inventoryMovement.map(i => i.keluar),
                        backgroundColor: '#E33353',
                        borderRadius: 6
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'top'
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // ── Chart: Stok Inventory (Doughnut) ─────────
        new Chart(document.getElementById('chart-stok'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(dataStok),
                datasets: [{
                    data: Object.values(dataStok),
                    backgroundColor: ['#F3AF23', '#4B49AC', '#57B657'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '65%',
            }
        });
    </script>
@endpush
