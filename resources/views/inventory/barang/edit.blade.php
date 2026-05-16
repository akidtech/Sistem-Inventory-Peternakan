@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <h3 class="font-weight-bold">Edit Barang</h3>
            <h6 class="text-muted">{{ $barang->kode_barang }}</h6>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('inventory.barang.update', $barang) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control"
                                value="{{ old('nama_barang', $barang->nama_barang) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori_id" class="form-control">
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}"
                                                {{ old('kategori_id', $barang->kategori_id) == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" name="satuan" class="form-control"
                                        value="{{ old('satuan', $barang->satuan) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Stok Minimum</label>
                                    <input type="number" name="stok_minimum" class="form-control"
                                        value="{{ old('stok_minimum', $barang->stok_minimum) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga Satuan (Rp)</label>
                                    <input type="number" name="harga_satuan" class="form-control"
                                        value="{{ old('harga_satuan', $barang->harga_satuan) }}">
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="ti-info-alt mr-2"></i>
                            Stok saat ini: <strong>{{ $barang->stok }} {{ $barang->satuan }}</strong>.
                            Ubah stok lewat menu <a href="{{ route('inventory.masuk.create') }}">Barang Masuk</a> atau
                            <a href="{{ route('inventory.keluar.create') }}">Barang Keluar</a>.
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="ti-save mr-1"></i> Update
                            </button>
                            <a href="{{ route('inventory.barang.index') }}" class="btn btn-danger text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
