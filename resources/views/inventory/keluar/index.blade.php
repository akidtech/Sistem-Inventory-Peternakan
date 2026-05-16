@extends('layouts.app')
@section('title', 'Barang Keluar')

@section('content')

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold">Barang Keluar</h3>
                <h6 class="text-muted">Riwayat pengeluaran barang</h6>
            </div>
            <a href="{{ route('inventory.keluar.create') }}" class="btn btn-primary">
                <i class="ti-plus mr-1"></i> Catat Barang Keluar
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

        <form method="GET" class="d-flex gap-2 align-items-center">

            {{-- Search --}}
            <input type="text" name="search" class="form-control mr-2" placeholder="Cari barang"
                value="{{ request('search') }}" style="width:220px;">

            {{-- Filter kategori --}}
            <select name="kategori" class="form-control mr-2">
                <option value="">Semua Kategori</option>

                <option value="Pakan" {{ request('kategori') == 'Pakan' ? 'selected' : '' }}>
                    Pakan
                </option>

                <option value="Obat" {{ request('kategori') == 'Obat' ? 'selected' : '' }}>
                    Obat
                </option>

                <option value="Vitamin" {{ request('kategori') == 'Vitamin' ? 'selected' : '' }}>
                    Vitamin
                </option>
            </select>

            <button type="submit" class="btn btn-sm btn-primary">
                Filter
            </button>

            @if (request('search') || request('kategori'))
                <a href="{{ route('inventory.keluar.index') }}" class="btn btn-sm btn-outline-secondary">
                    Reset
                </a>
            @endif
        </form>

        <small class="text-muted">
            Total: {{ $keluar->total() }} data
        </small>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Keperluan</th>
                                    <th>Dicatat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($keluar as $i => $k)
                                    <tr>
                                        <td>{{ $keluar->firstItem() + $loop->index }}</td>
                                        <td>{{ $k->tanggal_keluar->format('d/m/Y') }}</td>
                                        <td>{{ $k->barang->nama_barang }}</td>
                                        <td>{{ $k->barang->kategori->nama }}</td>
                                        <td>{{ $k->jumlah }} {{ $k->barang->satuan }}</td>
                                        <td>{{ $k->keperluan ?? '-' }}</td>
                                        <td>{{ $k->user->name }}</td>
                                        <td>
                                            <form action="{{ route('inventory.keluar.destroy', $k) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus"
                                                    data-nama="{{ $k->barang->nama_barang }}">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">Belum ada data barang keluar
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $keluar->links() }}</div>
                </div>
            </div>
        </div>
    </div>

@endsection
