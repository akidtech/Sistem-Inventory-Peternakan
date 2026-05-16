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

        {{-- Total Ternak --}}
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Total Ternak</p>
                    <p class="fs-30 mb-2">{{ $totalTernak }}</p>
                    <p><i class="ti-arrow-up text-success"></i> Semua ternak aktif</p>
                </div>
            </div>
        </div>

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

        {{-- Chart: Ternak per Jenis (Pie) --}}
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Komposisi Populasi Ternak</p>
                    <p class="font-weight-500 text-muted">Distribusi ternak berdasarkan jenis</p>
                    <canvas id="chart-jenis" height="200"></canvas>
                </div>
            </div>
        </div>

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
                                                class="{{ $notif->tipe == 'ternak_siap_jual' ? 'text-success' : 'text-warning' }}">
                                                <i
                                                    class="ti-{{ $notif->tipe == 'ternak_siap_jual' ? 'star' : 'alert' }} mr-1"></i>
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
        const dataJenis = @json($ternakPerJenis);
        const inventoryMovement = @json($inventoryMovement);
        const dataStok = @json($stokPerKategori);

        // ── Chart: Ternak per Jenis (Pie) ────────────
        new Chart(document.getElementById('chart-jenis'), {
            type: 'pie',
            data: {
                labels: Object.keys(dataJenis).map(j => j.charAt(0).toUpperCase() + j.slice(1)),
                datasets: [{
                    data: Object.values(dataJenis),
                    backgroundColor: ['#26C6DA', '#8E44AD'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // ── Chart: Aktivitas Inventory (Bar) ────────────────
        new Chart(document.getElementById('chart-inventory'), {
            type: 'bar',
            data: {
                labels: Object.keys(inventoryMovement),
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: Object.values(inventoryMovement),
                    backgroundColor: [
                        '#57B657', // masuk
                        '#E33353' // keluar
                    ],
                    borderRadius: 8,
                    barThickness: 60
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        min: 0,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
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
