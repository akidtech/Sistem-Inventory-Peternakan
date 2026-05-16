@extends('layouts.app')
@section('title', 'Barang Masuk')

@section('content')

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold">Barang Masuk</h3>
                <h6 class="text-muted">Riwayat penerimaan barang</h6>
            </div>
            <a href="{{ route('inventory.masuk.create') }}" class="btn btn-primary">
                <i class="ti-plus mr-1"></i> Catat Barang Masuk
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
                <a href="{{ route('inventory.masuk.index') }}" class="btn btn-sm btn-outline-secondary">
                    Reset
                </a>
            @endif
        </form>

        <small class="text-muted">
            Total: {{ $masuk->total() }} data
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
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                    <th>Supplier</th>
                                    <th>Dicatat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($masuk as $i => $m)
                                    <tr>
                                        <td>{{ $masuk->firstItem() + $loop->index }}</td>
                                        <td>{{ $m->tanggal_masuk->format('d/m/Y') }}</td>
                                        <td>{{ $m->barang->nama_barang }}</td>
                                        <td>{{ $m->barang->kategori->nama }}</td>
                                        <td>{{ $m->jumlah }} {{ $m->barang->satuan }}</td>
                                        <td>Rp {{ number_format($m->harga_satuan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($m->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $m->supplier ?? '-' }}</td>
                                        <td>{{ $m->user->name }}</td>
                                        <td>
                                            <form action="{{ route('inventory.masuk.destroy', $m) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus"
                                                    data-nama="{{ $m->barang->nama_barang }}">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">Belum ada data barang masuk
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $masuk->links() }}</div>
                </div>
            </div>
        </div>
    </div>

@endsection
