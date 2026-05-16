@extends('layouts.app')

@section('title', 'Tambah Ternak')

@section('content')

    <div class="row">
        <div class="col-12 mb-3">
            <h3 class="font-weight-bold">Tambah Ternak</h3>
            <h6 class="text-muted">Isi data ternak baru</h6>
        </div>
    </div>

    <form action="{{ route('ternak.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="card grid-margin">
                    <div class="card-body">
                        <h5 class="card-title">Data Ternak</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Ternak <span class="text-danger">*</span></label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                        placeholder="cth: Si Brewok">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Ternak <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                        <option value="">-- Pilih Jenis --</option>
                                        <optgroup label="Sapi">
                                            <option value="limousin" {{ old('jenis') == 'limousin' ? 'selected' : '' }}>
                                                Limousin
                                            </option>
                                            <option value="simental" {{ old('jenis') == 'simental' ? 'selected' : '' }}>
                                                Simental
                                            </option>
                                            <option value="po" {{ old('jenis') == 'po' ? 'selected' : '' }}>PO
                                                (Peranakan
                                                Ongole)</option>
                                            <option value="angus" {{ old('jenis') == 'angus' ? 'selected' : '' }}>Angus
                                            </option>
                                            <option value="brahman" {{ old('jenis') == 'brahman' ? 'selected' : '' }}>
                                                Brahman</option>
                                            <option value="bali" {{ old('jenis') == 'bali' ? 'selected' : '' }}>Sapi Bali
                                            </option>
                                            <option value="madura" {{ old('jenis') == 'madura' ? 'selected' : '' }}>Sapi
                                                Madura
                                            </option>
                                            <option value="friesian_holstein"
                                                {{ old('jenis') == 'friesian_holstein' ? 'selected' : '' }}>Friesian
                                                Holstein (FH)</option>
                                        </optgroup>
                                        <optgroup label="Kambing">
                                            <option value="etawa" {{ old('jenis') == 'etawa' ? 'selected' : '' }}>
                                                Kambing Etawa</option>
                                            <option value="boer" {{ old('jenis') == 'boer' ? 'selected' : '' }}>
                                                Kambing Boer</option>
                                            <option value="kacang" {{ old('jenis') == 'kacang' ? 'selected' : '' }}>
                                                Kambing Kacang</option>
                                            <option value="jawarandu" {{ old('jenis') == 'jawarandu' ? 'selected' : '' }}>
                                                Jawarandu</option>
                                            <option value="saanen" {{ old('jenis') == 'saanen' ? 'selected' : '' }}>
                                                Saanen</option>
                                        </optgroup>
                                        <option value="lainnya" {{ old('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin"
                                        class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="jantan" {{ old('jenis_kelamin') == 'jantan' ? 'selected' : '' }}>
                                            Jantan</option>
                                        <option value="betina" {{ old('jenis_kelamin') == 'betina' ? 'selected' : '' }}>
                                            Betina</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Berat (kg) <span class="text-danger">*</span></label>
                                    <input type="number" name="berat" step="0.1"
                                        class="form-control @error('berat') is-invalid @enderror"
                                        value="{{ old('berat') }}" placeholder="cth: 250">
                                    @error('berat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Umur (bulan) <span class="text-danger">*</span></label>
                                    <input type="number" name="umur"
                                        class="form-control @error('umur') is-invalid @enderror"
                                        value="{{ old('umur') }}" placeholder="cth: 24">
                                    @error('umur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
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
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kesehatan <span class="text-danger">*</span></label>
                                    <select name="kesehatan" class="form-control @error('kesehatan') is-invalid @enderror">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="sangat_sehat"
                                            {{ old('kesehatan') == 'sangat_sehat' ? 'selected' : '' }}>Sangat Sehat
                                        </option>
                                        <option value="sehat" {{ old('kesehatan') == 'sehat' ? 'selected' : '' }}>
                                            Sehat</option>
                                        <option value="cukup" {{ old('kesehatan') == 'cukup' ? 'selected' : '' }}>Cukup
                                            Sehat</option>
                                        <option value="kurang_sehat"
                                            {{ old('kesehatan') == 'kurang_sehat' ? 'selected' : '' }}>Kurang Sehat
                                        </option>
                                        <option value="tidak_sehat"
                                            {{ old('kesehatan') == 'tidak_sehat' ? 'selected' : '' }}>Tidak Sehat</option>
                                    </select>
                                    @error('kesehatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kondisi Fisik <span class="text-danger">*</span></label>
                                    <select name="kondisi_fisik"
                                        class="form-control @error('kondisi_fisik') is-invalid @enderror">
                                        <option value="">-- Pilih Kondisi --</option>
                                        <option value="sangat_baik"
                                            {{ old('kondisi_fisik') == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik
                                        </option>
                                        <option value="baik" {{ old('kondisi_fisik') == 'baik' ? 'selected' : '' }}>Baik
                                        </option>
                                        <option value="cukup" {{ old('kondisi_fisik') == 'cukup' ? 'selected' : '' }}>
                                            Cukup</option>
                                        <option value="kurang" {{ old('kondisi_fisik') == 'kurang' ? 'selected' : '' }}>
                                            Kurang
                                        </option>
                                        <option value="buruk" {{ old('kondisi_fisik') == 'buruk' ? 'selected' : '' }}>
                                            Buruk</option>
                                    </select>
                                    @error('kondisi_fisik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga Beli (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="harga_beli"
                                        class="form-control @error('harga_beli') is-invalid @enderror"
                                        value="{{ old('harga_beli') }}" placeholder="cth: 15000000">
                                    @error('harga_beli')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga Jual (Rp) <small class="text-muted">(opsional)</small></label>
                                    <input type="number" name="harga_jual"
                                        class="form-control @error('harga_jual') is-invalid @enderror"
                                        value="{{ old('harga_jual') }}" placeholder="cth: 19000000">
                                    @error('harga_jual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- Tombol di dalam card-body --}}
                        <div class="d-flex mt-3">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="ti-save mr-1"></i> Simpan Ternak
                            </button>
                            <a href="{{ route('ternak.index') }}" class="btn btn-danger text-center">
                                Batal
                            </a>
                        </div>

                    </div>{{-- end card-body --}}
                </div>{{-- end card --}}
            </div>{{-- end col --}}
        </div>{{-- end row --}}

    </form>

@endsection
