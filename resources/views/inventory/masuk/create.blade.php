@extends('layouts.app')
@section('title', 'Catat Barang Masuk')

@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <h3 class="font-weight-bold">Catat Barang Masuk</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('inventory.masuk.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Barang <span class="text-danger">*</span></label>
                            <select name="barang_id" class="form-control @error('barang_id') is-invalid @enderror"
                                id="select-barang">
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->id_barang }}" data-stok="{{ $b->stok }}"
                                        data-satuan="{{ $b->satuan }}" data-harga="{{ $b->harga_satuan }}"
                                        {{ old('barang_id') == $b->id_barang ? 'selected' : '' }}>
                                        {{ $b->nama_barang }} (Stok: {{ $b->stok }} {{ $b->satuan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah" id="input-jumlah"
                                        class="form-control @error('jumlah') is-invalid @enderror"
                                        value="{{ old('jumlah') }}" min="1">
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="harga_satuan" id="input-harga"
                                        class="form-control @error('harga_satuan') is-invalid @enderror"
                                        value="{{ old('harga_satuan') }}">
                                    @error('harga_satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Preview Total --}}
                        <div class="alert alert-info" id="preview-total" style="display:none">
                            <strong>Total: </strong> <span id="nilai-total">Rp 0</span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_masuk"
                                        class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                        value="{{ old('tanggal_masuk', date('Y-m-d')) }}">
                                    @error('tanggal_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <input type="text" name="supplier" class="form-control"
                                        value="{{ old('supplier') }}" placeholder="Nama supplier (opsional)">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="ti-save mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('inventory.masuk.index') }}" class="btn btn-danger text-center">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        // Auto-isi harga & preview total
        document.getElementById('select-barang').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            document.getElementById('input-harga').value = opt.dataset.harga || '';
            hitungTotal();
        });

        ['input-jumlah', 'input-harga'].forEach(id => {
            document.getElementById(id).addEventListener('input', hitungTotal);
        });

        function hitungTotal() {
            const jumlah = parseInt(document.getElementById('input-jumlah').value) || 0;
            const harga = parseInt(document.getElementById('input-harga').value) || 0;
            const total = jumlah * harga;

            if (total > 0) {
                document.getElementById('preview-total').style.display = 'block';
                document.getElementById('nilai-total').textContent =
                    'Rp ' + total.toLocaleString('id-ID');
            } else {
                document.getElementById('preview-total').style.display = 'none';
            }
        }
    </script>
@endpush
