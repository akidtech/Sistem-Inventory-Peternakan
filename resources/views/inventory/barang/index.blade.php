@extends('layouts.app')
@section('title', 'Data Barang')

@section('content')

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold">Data Barang</h3>
                <h6 class="text-muted">Kelola stok inventory</h6>
            </div>
            {{-- Tombol Tambah — admin only --}}
            @if (auth()->user()->isAdmin())
                <a href="{{ route('inventory.barang.create') }}" class="btn btn-primary">
                    <i class="ti-plus mr-1"></i> Tambah Barang
                </a>
            @endif
        </div>
    </div>

    {{-- Alert stok menipis --}}
    @php $menipis = \App\Models\Barang::stokMenurun()->with('kategori')->get(); @endphp
    @if ($menipis->count() > 0)
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="ti-alert mr-2"></i>
            <strong>Stok Menipis!</strong>
            {{ $menipis->pluck('nama_barang')->join(', ') }} perlu segera di-restock.
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

        <form method="GET" class="d-flex gap-2 align-items-center">

            {{-- Search --}}
            <input type="text" name="search" class="form-control mr-2" placeholder="Cari barang"
                value="{{ request('search') }}" style="width: 220px;">

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
                <a href="{{ route('inventory.barang.index') }}" class="btn btn-sm btn-outline-secondary">
                    Reset
                </a>
            @endif

        </form>

        <small class="text-muted">
            Total: {{ $barang->total() }} barang
        </small>
    </div>

    <div class="row mb-4">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                    <th>Min Stok</th>
                                    <th>Harga Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang as $i => $b)
                                    <tr class="{{ $b->isStokMenipis() ? 'table-warning' : '' }}">
                                        <td>{{ $barang->firstItem() + $loop->index }}</td>
                                        <td><code>{{ $b->kode_barang }}</code></td>
                                        <td>
                                            {{ $b->nama_barang }}
                                            @if ($b->isStokMenipis())
                                                <span class="badge badge-warning ml-1">Menipis!</span>
                                            @endif
                                        </td>
                                        <td>{{ $b->kategori->nama }}</td>
                                        <td>{{ $b->satuan }}</td>
                                        <td>
                                            <strong class="{{ $b->isStokMenipis() ? 'text-danger' : 'text-success' }}">
                                                {{ $b->stok }}
                                            </strong>
                                        </td>
                                        <td>{{ $b->stok_minimum }}</td>
                                        <td>Rp {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                                        {{-- Tombol Edit & Hapus di tabel — admin only --}}
                                        <td>
                                            @if (auth()->user()->isAdmin())
                                                <a href="{{ route('inventory.barang.edit', $b) }}"
                                                    class="btn btn-sm btn-outline-warning">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('inventory.barang.destroy', $b) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-hapus"
                                                        data-nama="{{ $b->nama_barang }}">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">Belum ada data barang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $barang->links() }}</div>
                </div>
            </div>
        </div>
    </div>

@endsection
