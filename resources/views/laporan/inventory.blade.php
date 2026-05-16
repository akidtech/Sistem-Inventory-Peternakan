@extends('layouts.app')
@section('title', 'Laporan Inventory')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endpush

@section('content')

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold">Laporan Inventory</h3>
                <h6 class="text-muted">Rekap stok & transaksi barang</h6>
            </div>
            <a href="{{ route('laporan.inventory.pdf', request()->query()) }}" class="btn btn-danger" target="_blank">
                <i class="ti-file mr-1"></i> Export PDF
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row align-items-end">
                <div class="col-md-3">
                    <label>Dari Tanggal</label>
                    <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                </div>
                <div class="col-md-3">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="ti-search mr-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('laporan.inventory') }}" class="btn btn-outline-secondary btn-block">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-tale text-center">
                <div class="card-body py-3">
                    <p class="mb-1">Total Barang</p>
                    <h3>{{ $summary['total_barang'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-light-danger text-center">
                <div class="card-body py-3">
                    <p class="mb-1">Stok Menipis</p>
                    <h3>{{ $summary['stok_menipis'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-dark-blue text-center">
                <div class="card-body py-3">
                    <p class="mb-1">Barang Masuk</p>
                    <h3>{{ $summary['aktivitas_masuk'] }}</h3>
                    <small>Aktivitas transaksi</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-light-blue text-center">
                <div class="card-body py-3">
                    <p class="mb-1">Barang Keluar</p>
                    <h3>{{ $summary['aktivitas_keluar'] }}</h3>
                    <small>Aktivitas transaksi</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Stok Barang --}}
    <div class="row mb-4">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Stok Barang Saat Ini</h5>
                    <div class="table-responsive">
                        <table class="table table-hover text-center" id="tabel-stok">
                            <thead class="thead-grey">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                    <th>Min Stok</th>
                                    <th>Harga Satuan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $i => $b)
                                    <tr class="{{ $b->isStokMenipis() ? 'table-warning' : '' }}">
                                        <td>{{ $i + 1 }}</td>
                                        <td><code>{{ $b->kode_barang }}</code></td>
                                        <td>{{ $b->nama_barang }}</td>
                                        <td>{{ $b->kategori->nama }}</td>
                                        <td>{{ $b->satuan }}</td>
                                        <td><strong
                                                class="{{ $b->isStokMenipis() ? 'text-danger' : 'text-success' }}">{{ $b->stok }}</strong>
                                        </td>
                                        <td>{{ $b->stok_minimum }}</td>
                                        <td>Rp {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($b->isStokMenipis())
                                                <span class="badge badge-warning">Menipis</span>
                                            @else
                                                <span class="badge badge-success">Aman</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Transaksi Masuk --}}
    <div class="row mb-4">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Barang Masuk</h5>
                    <div class="table-responsive">
                        <table class="table table-hover text-center" id="tabel-masuk">
                            <thead class="thead-grey">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                    <th>Supplier</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($masuk as $i => $m)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $m->tanggal_masuk->format('d/m/Y') }}</td>
                                        <td>{{ $m->barang->nama_barang }}</td>
                                        <td>{{ $m->barang->kategori->nama }}</td>
                                        <td>{{ $m->jumlah }} {{ $m->barang->satuan }}</td>
                                        <td>Rp {{ number_format($m->harga_satuan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($m->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $m->supplier ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Transaksi Keluar --}}
    <div class="row mb-4">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Barang Keluar</h5>

                    <div class="table-responsive">
                        <table class="table table-hover text-center" id="tabel-keluar">
                            <thead class="thead-grey">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Keperluan</th>
                                    <th>Dicatat Oleh</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($keluar as $i => $k)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>

                                        <td>
                                            {{ $k->tanggal_keluar->format('d/m/Y') }}</td>
                                        <td>
                                            {{ $k->barang->nama_barang }}
                                        </td>
                                        <td>
                                            {{ $k->barang->kategori->nama }}
                                        </td>
                                        <td>
                                            {{ $k->jumlah }}
                                            {{ $k->barang->satuan }}
                                        </td>
                                        <td>
                                            {{ $k->keperluan ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $k->user->name }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script>
        ['#tabel-stok', '#tabel-masuk', '#tabel-keluar'].forEach(id => {
            $(id).DataTable({
                language: {
                    search: "Cari:"
                }
            });
        });
    </script>
@endpush
