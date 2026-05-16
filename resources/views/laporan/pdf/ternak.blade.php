<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Ternak</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #2E7D32;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 16px;
            color: #2E7D32;
            margin-bottom: 4px;
        }

        .header h3 {
            font-size: 13px;
            color: #333;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 10px;
            color: #666;
        }

        h4 {
            font-size: 12px;
            margin: 15px 0 6px;
            color: #2E7D32;
            border-bottom: 1px solid #2E7D32;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        th {
            background: #2E7D32;
            color: white;
            padding: 5px 7px;
            text-align: left;
        }

        td {
            padding: 4px 7px;
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-orange {
            background: #ffe5b4;
            color: #b35a00;
        }

        .badge-secondary {
            background: #e2e3e5;
            color: #383d41;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-success {
            color: #2E7D32;
            font-weight: bold;
        }

        .text-danger {
            color: #E33353;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">
        <h2>PETERNAKAN SUMBER MAKMUR</h2>
        <h3>LAPORAN DATA TERNAK</h3>

        <p>
            Dicetak pada:
            {{ now()->translatedFormat('d F Y H:i') }}

            @if (request('dari') || request('sampai'))
                &nbsp;|&nbsp; Periode:
                {{ request('dari') ? \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') : '-' }}
                s/d
                {{ request('sampai') ? \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') : '-' }}
            @endif
        </p>
    </div>

    {{-- Summary --}}
    <table style="margin-bottom: 15px;">
        <tr>

            <td style="width:18%; background:#4B49AC; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Total Ternak</div>
                <div style="font-size:20px; font-weight:bold;">
                    {{ $summary['total'] }}
                </div>
            </td>

            <td style="width:2%;"></td>

            <td style="width:18%; background:#7978E9; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Aktif</div>
                <div style="font-size:20px; font-weight:bold;">
                    {{ $summary['aktif'] }}
                </div>
            </td>

            <td style="width:2%;"></td>

            <td style="width:18%; background:#2E7D32; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Siap Jual</div>
                <div style="font-size:20px; font-weight:bold;">
                    {{ $summary['siap_jual'] }}
                </div>
            </td>

            <td style="width:2%;"></td>

            <td style="width:18%; background:#E33353; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Terjual</div>
                <div style="font-size:20px; font-weight:bold;">
                    {{ $summary['terjual'] }}
                </div>
            </td>

            <td style="width:2%;"></td>

            <td style="width:20%; background:#F3AF23; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Total Keuntungan</div>
                <div style="font-size:13px; font-weight:bold;">
                    Rp {{ number_format($summary['total_jual'] - $summary['total_beli'], 0, ',', '.') }}
                </div>
            </td>

        </tr>
    </table>

    {{-- Tabel Data Ternak --}}
    <h4>Data Ternak</h4>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Jenis</th>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Berat</th>
                <th class="text-center">Umur</th>
                <th class="text-center">Kesehatan</th>
                <th class="text-center">Kondisi Fisik</th>
                <th class="text-center">Status</th>
                <th class="text-center">Harga Beli</th>
                <th class="text-center">Harga Jual</th>
                <th class="text-center">Keuntungan</th>
                <th class="text-center">Tanggal Masuk</th>
            </tr>
        </thead>

        <tbody>
            @forelse($ternak as $i => $t)
                <tr>

                    <td class="text-center">{{ $i + 1 }}</td>

                    <td class="text-center">{{ $t->kode_ternak }}</td>

                    <td class="text-center">{{ $t->nama }}</td>

                    <td class="text-center">{{ ucfirst($t->jenis) }}</td>

                    <td class="text-center">
                        @if ($t->jenis_kelamin == 'jantan')
                            <span class="badge badge-blue" style="background:#1c63af; color:white;">Jantan</span>
                        @elseif($t->jenis_kelamin == 'betina')
                            <span class="badge badge-pink" style="background:#ff006f; color:white;">Betina</span>
                        @else
                            <span
                                class="badge
                                                    badge-secondary">{{ $t->jenis_kelamin }}</span>
                        @endif
                    </td>
                    </td>

                    <td class="text-center">
                        {{ $t->berat }} kg
                    </td>

                    <td class="text-center">
                        {{ $t->umur }} bln
                    </td>

                    <td class="text-center">
                        @if ($t->kesehatan == 'sangat_sehat')
                            <span class="badge badge-success">Sangat Sehat</span>
                        @elseif($t->kesehatan == 'sehat')
                            <span class="badge badge-info">Sehat</span>
                        @elseif($t->kesehatan == 'cukup')
                            <span class="badge badge-warning">Cukup Sehat</span>
                        @elseif($t->kesehatan == 'kurang_sehat')
                            <span class="badge badge-orange">Kurang
                                Sehat</span>
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
                    <td class="text-center">
                        {{ $kondisiLabel[$t->kondisi_fisik] ?? ucfirst($t->kondisi_fisik) }}
                    </td>
                    <td class="text-center">
                        @if ($t->status == 'siap_jual')
                            <span class="badge badge-success">
                                Siap Jual
                            </span>
                        @elseif($t->status == 'aktif')
                            <span class="badge badge-info">
                                Aktif
                            </span>
                        @else
                            <span class="badge badge-secondary">
                                Terjual
                            </span>
                        @endif
                    </td>

                    <td class="text-left">
                        Rp {{ number_format($t->harga_beli, 0, ',', '.') }}
                    </td>

                    <td class="text-left">
                        Rp {{ number_format($t->harga_jual ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-left {{ $t->keuntungan >= 0 ? 'text-success' : 'text-danger' }}">
                        Rp {{ number_format($t->keuntungan, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        {{ $t->tanggal_masuk->translatedFormat('d/m/Y') }}
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        Peternakan Sumber Makmur &nbsp;|&nbsp;
        Dicetak oleh: {{ auth()->user()->name }} &nbsp;|&nbsp;
        {{ now()->translatedFormat('d F Y H:i') }}
    </div>

</body>

</html>
