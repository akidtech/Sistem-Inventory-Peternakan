@extends('layouts.app')
@section('title', 'Tambah Barang')

@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <h3 class="font-weight-bold">Tambah Barang</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('inventory.barang.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang"
                                class="form-control @error('nama_barang') is-invalid @enderror"
                                value="{{ old('nama_barang') }}" placeholder="cth: Rumput Gajah">
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori_id"
                                        class="form-control @error('kategori_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id_kategori }}"
                                                {{ old('kategori_id') == $k->id_kategori ? 'selected' : '' }}>
                                                {{ $k->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan <span class="text-danger">*</span></label>
                                    <input type="text" name="satuan"
                                        class="form-control @error('satuan') is-invalid @enderror"
                                        value="{{ old('satuan') }}" placeholder="cth: kg, liter, botol">
                                    @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Stok Awal <span class="text-danger">*</span></label>
                                    <input type="number" name="stok"
                                        class="form-control @error('stok') is-invalid @enderror"
                                        value="{{ old('stok', 0) }}" min="0">
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Stok Minimum <span class="text-danger">*</span></label>
                                    <input type="number" name="stok_minimum"
                                        class="form-control @error('stok_minimum') is-invalid @enderror"
                                        value="{{ old('stok_minimum', 10) }}" min="0">
                                    @error('stok_minimum')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="harga_satuan"
                                        class="form-control @error('harga_satuan') is-invalid @enderror"
                                        value="{{ old('harga_satuan') }}" min="0">
                                    @error('harga_satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="ti-save mr-1"></i> Simpan
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
