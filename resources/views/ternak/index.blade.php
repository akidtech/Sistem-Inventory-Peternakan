@extends('layouts.app')

@section('title', 'Data Ternak')


@section('content')

    <div class="row">
        <div class="col-12 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="font-weight-bold">Data Ternak</h3>
                    <h6 class="text-muted">Kelola semua data ternak</h6>
                </div>
                <a href="{{ route('ternak.create') }}" class="btn btn-primary">
                    <i class="ti-plus mr-1"></i> Tambah Ternak
                </a>
            </div>
        </div>
    </div>

    <form method="GET" class="d-flex align-items-center mb-3">

        {{-- Search --}}
        <input type="text" name="search" class="form-control mr-2" placeholder="Cari ternak"
            value="{{ request('search') }}" style="width:220px;">

        {{-- Filter jenis hewan --}}
        <select name="hewan" class="form-control mr-2" style="width:180px;">
            <option value="">Semua Ternak</option>
            <option value="sapi" {{ request('hewan') == 'sapi' ? 'selected' : '' }}>
                Sapi
            </option>
            <option value="kambing" {{ request('hewan') == 'kambing' ? 'selected' : '' }}>
                Kambing
            </option>
        </select>

        <button type="submit" class="btn btn-sm btn-primary">
            Filter
        </button>

        <a href="{{ route('ternak.index') }}" class="btn btn-sm btn-outline-secondary">
            Reset
        </a>
    </form>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Berat</th>
                                    <th>Umur</th>
                                    <th>Kesehatan</th>
                                    <th>Kondisi Fisik</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ternak as $i => $t)
                                    <tr>
                                        <td>{{ $ternak->firstItem() + $i }}</td>
                                        <td><code>{{ $t->kode_ternak }}</code></td>
                                        <td>{{ $t->nama }}</td>
                                        @php
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
                                        <td>{{ $jenisLabel[$t->jenis] ?? ucfirst($t->jenis) }}</td>
                                        <td>
                                            @if ($t->jenis_kelamin == 'jantan')
                                                <span class="badge badge-blue"
                                                    style="background:#1c63af; color:white;">Jantan</span>
                                            @elseif($t->jenis_kelamin == 'betina')
                                                <span class="badge badge-pink"
                                                    style="background:#ff006f; color:white;">Betina</span>
                                            @else
                                                <span
                                                    class="badge
                                                    badge-secondary">{{ $t->jenis_kelamin }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $t->berat }} kg</td>
                                        <td>{{ $t->umur }} bulan</td>
                                        <td>
                                            @if ($t->kesehatan == 'sangat_sehat')
                                                <span class="badge badge-success">Sangat Sehat</span>
                                            @elseif($t->kesehatan == 'sehat')
                                                <span class="badge badge-info">Sehat</span>
                                            @elseif($t->kesehatan == 'cukup')
                                                <span class="badge badge-warning">Cukup Sehat</span>
                                            @elseif($t->kesehatan == 'kurang_sehat')
                                                <span class="badge badge-orange"
                                                    style="background:#fd7e14; color:white;">Kurang Sehat</span>
                                            @elseif($t->kesehatan == 'tidak_sehat')
                                                <span class="badge badge-danger">Tidak Sehat</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $t->kesehatan }}</span>
                                            @endif
                                        </td>
                                        @php
                                            $kondisiLabel = [
                                                'sangat_baik' => 'Sangat Baik',
                                                'baik' => 'Baik',
                                                'cukup' => 'Cukup',
                                                'kurang' => 'Kurang',
                                                'buruk' => 'Buruk',
                                            ];
                                        @endphp
                                        <td>{{ $kondisiLabel[$t->kondisi_fisik] ?? ucfirst($t->kondisi_fisik) }}</td>
                                        <td>
                                            @if ($t->status == 'siap_jual')
                                                <span class="badge badge-success">Siap Jual</span>
                                            @elseif($t->status == 'aktif')
                                                <span class="badge badge-info">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Terjual</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('ternak.show', $t) }}" class="btn btn-sm btn-outline-info"
                                                title="Detail">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="{{ route('ternak.edit', $t) }}" class="btn btn-sm btn-outline-warning"
                                                title="Edit">
                                                <i class="ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('ternak.destroy', $t) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus"
                                                    data-nama="{{ $t->nama }}">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <i class="ti-info-alt mr-2"></i> Belum ada data ternak.
                                            <a href="{{ route('ternak.create') }}">Tambah sekarang</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $ternak->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
