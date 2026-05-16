@extends('layouts.app')

@section('title', 'Detail Ternak')

@section('content')

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold mb-1">{{ $ternak->nama }}</h3>
                <p class="text-muted"><code>{{ $ternak->kode_ternak }}</code></p>
            </div>
            <div>
                <a href="{{ route('ternak.edit', $ternak) }}" class="btn btn-warning mr-2">
                    <i class="ti-pencil mr-1"></i> Edit
                </a>
                <a href="{{ route('ternak.index') }}" class="btn btn-danger">
                    <i class="ti-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- Info Ternak --}}
        <div class="col-md-12">
            <div class="card grid-margin">
                <div class="card-body">
                    <h5 class="card-title">Informasi Ternak</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted py-3" width="35%" style="vertical-align: middle;">Nama</td>
                            <td class="py-3" style="vertical-align: middle;"><strong>{{ $ternak->nama }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Jenis</td>
                            <td class="py-3" style="vertical-align: middle;">@php
                                $jenisLabel = [
                                    'limousin' => 'Limousin',
                                    'simental' => 'Simental',
                                    'po' => 'PO',
                                    'angus' => 'Angus',
                                    'brahman' => 'Brahman',
                                    'bali' => 'Sapi Bali',
                                    'madura' => 'Sapi Madura',
                                    'friesian_holstein' => 'Friesian Holstein',
                                    'etawa' => 'Etawa',
                                    'boer' => 'Boer',
                                    'kacang' => 'Kacang',
                                    'jawarandu' => 'Jawarandu',
                                    'saanen' => 'Saanen',
                                    'lainnya' => 'Lainnya',
                                ];
                            @endphp
                                {{ $jenisLabel[$ternak->jenis] ?? ucfirst($ternak->jenis) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Jenis Kelamin</td>
                            <td class="py-3" style="vertical-align: middle;">
                                @if ($ternak->jenis_kelamin == 'jantan')
                                    <span class="badge badge-blue" style="background:#1c63af; color:white;">Jantan</span>
                                @elseif($ternak->jenis_kelamin == 'betina')
                                    <span class="badge badge-pink" style="background:#ff006f; color:white;">Betina</span>
                                @else
                                    <span
                                        class="badge
                                                    badge-secondary">{{ $ternak->jenis_kelamin }}</span>
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Berat</td>
                            <td class="py-3" style="vertical-align: middle;">{{ $ternak->berat }} kg</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Umur</td>
                            <td class="py-3" style="vertical-align: middle;">{{ $ternak->umur }} bulan</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Kesehatan</td>
                            <td class="py-3" style="vertical-align: middle;">
                                @if ($ternak->kesehatan == 'sangat_sehat')
                                    <span class="badge badge-success">Sangat Sehat</span>
                                @elseif($ternak->kesehatan == 'sehat')
                                    <span class="badge badge-info">Sehat</span>
                                @elseif($ternak->kesehatan == 'cukup')
                                    <span class="badge badge-warning">Cukup Sehat</span>
                                @elseif($ternak->kesehatan == 'kurang_sehat')
                                    <span class="badge badge-orange" style="background:#fd7e14; color:white;">Kurang
                                        Sehat</span>
                                @elseif($ternak->kesehatan == 'tidak_sehat')
                                    <span class="badge badge-danger">Tidak Sehat</span>
                                @else
                                    <span class="badge badge-secondary">{{ $ternak->kesehatan }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Kondisi Fisik</td>
                            <td class="py-3" style="vertical-align: middle;">{{ ucfirst($ternak->kondisi_fisik) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Status</td>
                            <td class="py-3" style="vertical-align: middle;">
                                @if ($ternak->status == 'siap_jual')
                                    <span class="badge badge-success">Siap Jual</span>
                                @elseif($ternak->status == 'aktif')
                                    <span class="badge badge-info">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Terjual</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Harga Beli</td>
                            <td class="py-3" style="vertical-align: middle;">Rp
                                {{ number_format($ternak->harga_beli, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Harga Jual</td>
                            <td class="py-3" style="vertical-align: middle;">Rp
                                {{ number_format($ternak->harga_jual ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Keuntungan</td>
                            <td class="py-3" style="vertical-align: middle;">
                                <strong class="{{ $ternak->keuntungan >= 0 ? 'text-success' : 'text-danger' }}">
                                    Rp {{ number_format($ternak->keuntungan, 0, ',', '.') }}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted py-3" style="vertical-align: middle;">Tanggal Masuk</td>
                            <td class="py-3" style="vertical-align: middle;">
                                {{ $ternak->tanggal_masuk->translatedFormat('d F Y') }}</td>
                        </tr>
                        @if ($ternak->keterangan)
                            <tr>
                                <td class="text-muted py-3" style="vertical-align: middle;">Keterangan</td>
                                <td class="py-3" style="vertical-align: middle;">{{ $ternak->keterangan }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
