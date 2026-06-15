@extends('layouts.app')
@section('title', 'Catat Barang Keluar')

@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <h3 class="font-weight-bold">Catat Barang Keluar</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('inventory.keluar.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Barang <span class="text-danger">*</span></label>
                            <select name="barang_id" class="form-control @error('barang_id') is-invalid @enderror"
                                id="select-barang">
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->id_barang }}" data-stok="{{ $b->stok }}"
                                        data-satuan="{{ $b->satuan }}"
                                        {{ old('barang_id') == $b->id_barang ? 'selected' : '' }}>
                                        {{ $b->nama_barang }} (Stok: {{ $b->stok }} {{ $b->satuan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info stok tersedia --}}
                        <div class="alert alert-info" id="info-stok" style="display:none">
                            <i class="ti-package mr-2"></i>
                            Stok tersedia: <strong id="nilai-stok">-</strong>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah"
                                        class="form-control @error('jumlah') is-invalid @enderror"
                                        value="{{ old('jumlah') }}" min="1" id="input-jumlah">
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Keluar <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_keluar"
                                        class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                        value="{{ old('tanggal_keluar', date('Y-m-d')) }}">
                                    @error('tanggal_keluar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keperluan</label>
                            <input type="text" name="keperluan" class="form-control" value="{{ old('keperluan') }}"
                                placeholder="cth: Pakan ternak sapi bulan April">
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="ti-save mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('inventory.keluar.index') }}" class="btn btn-danger text-center">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        document.getElementById('select-barang').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            const stok = opt.dataset.stok;
            const sat = opt.dataset.satuan;

            if (stok) {
                document.getElementById('info-stok').style.display = 'block';
                document.getElementById('nilai-stok').textContent = stok + ' ' + sat;
                document.getElementById('input-jumlah').max = stok;
            } else {
                document.getElementById('info-stok').style.display = 'none';
            }
        });
    </script>
@endpush
