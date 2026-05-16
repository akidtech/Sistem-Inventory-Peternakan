@extends('layouts.app')
@section('title', 'Laporan Ternak')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endpush

@section('content')

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold">Laporan Ternak</h3>
                <h6 class="text-muted">Data lengkap seluruh ternak</h6>
            </div>
            <a href="{{ route('laporan.ternak.pdf', request()->query()) }}" class="btn btn-danger" target="_blank">
                <i class="ti-file mr-1"></i> Export PDF
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row align-items-end">
                        <div class="col-md-2">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">Semua</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="siap_jual" {{ request('status') == 'siap_jual' ? 'selected' : '' }}>Siap Jual
                                </option>
                                <option value="terjual" {{ request('status') == 'terjual' ? 'selected' : '' }}>Terjual
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Jenis</label>
                            <select name="jenis" class="form-control">
                                <option value="">Semua</option>
                                @foreach (['limousin', 'simental', 'po', 'angus', 'brahman', 'bali', 'madura', 'friesian_holstein', 'lainnya'] as $j)
                                    <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>
                                        {{ ucfirst($j) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Dari Tanggal</label>
                            <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                        </div>
                        <div class="col-md-2">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="ti-search mr-1"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('laporan.ternak') }}" class="btn btn-outline-secondary btn-block">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card card-tale text-center">
                <div class="card-body py-3">
                    <p class="mb-1">Total</p>
                    <h3>{{ $summary['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-light-blue text-center">
                <div class="card-body py-3">
                    <p class="mb-1">Aktif</p>
                    <h3>{{ $summary['aktif'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-dark-blue text-center">
                <div class="card-body py-3">
                    <p class="mb-1">Siap Jual</p>
                    <h3>{{ $summary['siap_jual'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-light-danger text-center">
                <div class="card-body py-3">
                    <p class="mb-1">Terjual</p>
                    <h3>{{ $summary['terjual'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card" style="border-left: 4px solid #57B657">
                <div class="card-body py-3">
                    <p class="mb-1 text-muted">Total Beli</p>
                    <h6 class="font-weight-bold">Rp {{ number_format($summary['total_beli'], 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card" style="border-left: 4px solid #4B49AC">
                <div class="card-body py-3">
                    <p class="mb-1 text-muted">Total Jual</p>
                    <h6 class="font-weight-bold">Rp {{ number_format($summary['total_jual'], 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabel-laporan">
                            <thead class="thead-grey">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Berat</th>
                                    <th>Umur</th>
                                    <th>Kesehatan</th>
                                    <th>Kondisi Fisik</th>
                                    <th>Status</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Keuntungan</th>
                                    <th>Tgl Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ternak as $i => $t)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><code>{{ $t->kode_ternak }}</code></td>
                                        <td>{{ $t->nama }}</td>
                                        <td>@php
                                            $jenisLabel = [
                                                'limousin' => 'Limousin',
                                                'simental' => 'Simental',
                                                'po' => 'PO',
                                                'angus' => 'Angus',
                                                'brahman' => 'Brahman',
                                                'bali' => 'Sapi Bali',
                                                'madura' => 'Sapi Madura',
                                                'friesian_holstein' => 'Friesian Holstein',
                                                'lainnya' => 'Lainnya',
                                            ];
                                        @endphp
                                            {{ $jenisLabel[$t->jenis] ?? ucfirst($t->jenis) }}</td>
                                        <td>{{ $t->berat }} kg</td>
                                        <td>{{ $t->umur }} bln</td>
                                        <td>
                                            @if ($t->kesehatan == 'sangat_sehat')
                                                <span class="badge badge-success">Sangat Sehat</span>
                                            @elseif($t->kesehatan == 'sehat')
                                                <span class="badge badge-info">Sehat</span>
                                            @elseif($t->kesehatan == 'cukup')
                                                <span class="badge badge-warning">Cukup Sehat</span>
                                            @elseif($t->kesehatan == 'kurang_sehat')
                                                <span class="badge badge-orange"
                                                    style="background:#fd7e14; color:white;">Kurang Sehat</span>
                                            @elseif($t->kesehatan == 'tidak_sehat')
                                                <span class="badge badge-danger">Tidak Sehat</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $t->kesehatan }}</span>
                                            @endif
                                        </td>
                                        @php
                                            $kondisiLabel = [
                                                'sangat_baik' => 'Sangat Baik',
                                                'baik' => 'Baik',
                                                'cukup' => 'Cukup',
                                                'kurang' => 'Kurang',
                                                'buruk' => 'Buruk',
                                            ];
                                        @endphp
                                        <td>{{ $kondisiLabel[$t->kondisi_fisik] ?? ucfirst($t->kondisi_fisik) }}</td>
                                        <td>
                                            @if ($t->status == 'siap_jual')
                                                <span class="badge badge-success">Siap Jual</span>
                                            @elseif($t->status == 'aktif')
                                                <span class="badge badge-info">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Terjual</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($t->harga_beli, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($t->harga_jual ?? 0, 0, ',', '.') }}</td>
                                        <td class="{{ $t->keuntungan >= 0 ? 'text-success' : 'text-danger' }}">
                                            Rp {{ number_format($t->keuntungan, 0, ',', '.') }}
                                        </td>
                                        <td>{{ $t->tanggal_masuk->translatedFormat('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-muted">Tidak ada data</td>
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
        $('#tabel-laporan').DataTable({
            language: {
                search: "Cari:",
                zeroRecords: "Tidak ada data"
            }
        });
    </script>
@endpush
