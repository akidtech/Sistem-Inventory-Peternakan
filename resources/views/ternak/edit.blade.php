@extends('layouts.app')

@section('title', 'Edit Ternak')

@section('content')

    <div class="row">
        <div class="col-12 mb-3">
            <h3 class="font-weight-bold">Edit Ternak</h3>
            <h6 class="text-muted">{{ $ternak->kode_ternak }} — {{ $ternak->nama }}</h6>
        </div>
    </div>

    <form action="{{ route('ternak.update', $ternak) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-12">
                <div class="card grid-margin">
                    <div class="card-body">
                        <h5 class="card-title">Data Ternak</h5>

                        {{-- Row 1: Nama & Jenis --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Ternak</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ old('nama', $ternak->nama) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Ternak <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                        <option value="">-- Pilih Jenis --</option>
                                        <optgroup label="Sapi">
                                            <option value="limousin"
                                                {{ old('jenis', $ternak->jenis) == 'limousin' ? 'selected' : '' }}>
                                                Limousin</option>
                                            <option value="simental"
                                                {{ old('jenis', $ternak->jenis) == 'simental' ? 'selected' : '' }}>
                                                Simental</option>
                                            <option value="po"
                                                {{ old('jenis', $ternak->jenis) == 'po' ? 'selected' : '' }}>
                                                PO (Peranakan Ongole)</option>
                                            <option value="angus"
                                                {{ old('jenis', $ternak->jenis) == 'angus' ? 'selected' : '' }}>
                                                Angus</option>
                                            <option value="brahman"
                                                {{ old('jenis', $ternak->jenis) == 'brahman' ? 'selected' : '' }}>
                                                Brahman</option>
                                            <option value="bali"
                                                {{ old('jenis', $ternak->jenis) == 'bali' ? 'selected' : '' }}>
                                                Sapi Bali</option>
                                            <option value="madura"
                                                {{ old('jenis', $ternak->jenis) == 'madura' ? 'selected' : '' }}>
                                                Sapi Madura</option>
                                            <option value="friesian_holstein"
                                                {{ old('jenis', $ternak->jenis) == 'friesian_holstein' ? 'selected' : '' }}>
                                                Friesian Holstein (FH)</option>
                                        </optgroup>
                                        <optgroup label="Kambing">
                                            <option value="etawa"
                                                {{ old('jenis', $ternak->jenis) == 'etawa' ? 'selected' : '' }}>Kambing
                                                Etawa</option>
                                            <option value="boer"
                                                {{ old('jenis', $ternak->jenis) == 'boer' ? 'selected' : '' }}>Kambing
                                                Boer</option>
                                            <option value="kacang"
                                                {{ old('jenis', $ternak->jenis) == 'kacang' ? 'selected' : '' }}>Kambing
                                                Kacang</option>
                                            <option value="jawarandu"
                                                {{ old('jenis', $ternak->jenis) == 'jawarandu' ? 'selected' : '' }}>
                                                Jawarandu</option>
                                            <option value="saanen"
                                                {{ old('jenis', $ternak->jenis) == 'saanen' ? 'selected' : '' }}>Saanen
                                            </option>
                                        </optgroup>
                                        <option value="lainnya"
                                            {{ old('jenis', $ternak->jenis) == 'lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Row 2: Jenis Kelamin, Status, Berat, Umur --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin"
                                        class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="jantan"
                                            {{ old('jenis_kelamin', $ternak->jenis_kelamin) == 'jantan' ? 'selected' : '' }}>
                                            Jantan</option>
                                        <option value="betina"
                                            {{ old('jenis_kelamin', $ternak->jenis_kelamin) == 'betina' ? 'selected' : '' }}>
                                            Betina</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif"
                                            {{ old('status', $ternak->status) == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="siap_jual"
                                            {{ old('status', $ternak->status) == 'siap_jual' ? 'selected' : '' }}>Siap Jual
                                        </option>
                                        <option value="terjual"
                                            {{ old('status', $ternak->status) == 'terjual' ? 'selected' : '' }}>Terjual
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Berat (kg)</label>
                                    <input type="number" name="berat" step="0.1" class="form-control"
                                        value="{{ old('berat', $ternak->berat) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Umur (bulan)</label>
                                    <input type="number" name="umur" class="form-control"
                                        value="{{ old('umur', $ternak->umur) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Row 3: Tanggal, Kesehatan, Kondisi Fisik --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" name="tanggal_masuk" class="form-control"
                                        value="{{ old('tanggal_masuk', $ternak->tanggal_masuk->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kesehatan</label>
                                    <select name="kesehatan" class="form-control">
                                        <option value="sangat_sehat"
                                            {{ old('kesehatan', $ternak->kesehatan) == 'sangat_sehat' ? 'selected' : '' }}>
                                            Sangat Sehat</option>
                                        <option value="sehat"
                                            {{ old('kesehatan', $ternak->kesehatan) == 'sehat' ? 'selected' : '' }}>
                                            Sehat</option>
                                        <option value="cukup"
                                            {{ old('kesehatan', $ternak->kesehatan) == 'cukup' ? 'selected' : '' }}>
                                            Cukup Sehat</option>
                                        <option value="kurang_sehat"
                                            {{ old('kesehatan', $ternak->kesehatan) == 'kurang_sehat' ? 'selected' : '' }}>
                                            Kurang Sehat</option>
                                        <option value="tidak_sehat"
                                            {{ old('kesehatan', $ternak->kesehatan) == 'tidak_sehat' ? 'selected' : '' }}>
                                            Tidak Sehat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kondisi Fisik</label>
                                    <select name="kondisi_fisik" class="form-control">
                                        <option value="sangat_baik"
                                            {{ old('kondisi_fisik', $ternak->kondisi_fisik) == 'sangat_baik' ? 'selected' : '' }}>
                                            Sangat Baik</option>
                                        <option value="baik"
                                            {{ old('kondisi_fisik', $ternak->kondisi_fisik) == 'baik' ? 'selected' : '' }}>
                                            Baik</option>
                                        <option value="cukup"
                                            {{ old('kondisi_fisik', $ternak->kondisi_fisik) == 'cukup' ? 'selected' : '' }}>
                                            Cukup</option>
                                        <option value="kurang"
                                            {{ old('kondisi_fisik', $ternak->kondisi_fisik) == 'kurang' ? 'selected' : '' }}>
                                            Kurang</option>
                                        <option value="buruk"
                                            {{ old('kondisi_fisik', $ternak->kondisi_fisik) == 'buruk' ? 'selected' : '' }}>
                                            Buruk</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Row 4: Harga --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga Beli (Rp)</label>
                                    <input type="number" name="harga_beli" class="form-control"
                                        value="{{ old('harga_beli', $ternak->harga_beli) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga Jual (Rp)</label>
                                    <input type="number" name="harga_jual" class="form-control"
                                        value="{{ old('harga_jual', $ternak->harga_jual) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $ternak->keterangan) }}</textarea>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex mt-3">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="ti-save mr-1"></i> Update Ternak
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
