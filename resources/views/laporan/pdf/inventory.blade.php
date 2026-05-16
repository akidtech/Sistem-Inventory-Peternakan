<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Inventory</title>
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

        .summary-row {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
        }

        .summary-box {
            flex: 1;
            padding: 8px;
            border-radius: 4px;
            text-align: center;
            color: white;
        }

        .summary-box .label {
            font-size: 10px;
            margin-bottom: 3px;
        }

        .summary-box .value {
            font-size: 18px;
            font-weight: bold;
        }

        .box-blue {
            background: #4B49AC;
        }

        .box-red {
            background: #E33353;
        }

        .box-green {
            background: #2E7D32;
        }

        .box-orange {
            background: #F3AF23;
        }

        .box-teal {
            background: #248AFD;
            color: white;
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

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-danger {
            color: #E33353;
            font-weight: bold;
        }

        .text-success {
            color: #2E7D32;
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

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">
        <h2>PETERNAKAN SUMBER MAKMUR</h2>
        <h3>LAPORAN INVENTORY</h3>
        <p>
            Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}
            @if (request('dari') || request('sampai'))
                &nbsp;|&nbsp; Periode:
                {{ request('dari') ? \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') : '-' }}
                s/d {{ request('sampai') ? \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') : '-' }}
            @endif
        </p>
    </div>

    {{-- Summary --}}
    <table style="margin-bottom: 15px;">
        <tr>
            <td style="width:18%; background:#4B49AC; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Total Barang</div>
                <div style="font-size:20px; font-weight:bold;">{{ $summary['total_barang'] }}</div>
            </td>
            <td style="width:2%;"></td>
            <td style="width:18%; background:#E33353; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Stok Menipis</div>
                <div style="font-size:20px; font-weight:bold;">{{ $summary['stok_menipis'] }}</div>
            </td>
            <td style="width:2%;"></td>
            <td style="width:18%; background:#2E7D32; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Barang Masuk</div>
                <div style="font-size:20px; font-weight:bold;">{{ $summary['aktivitas_masuk'] }}</div>
                <small>Aktivitas transaksi</small>
            </td>
            <td style="width:2%;"></td>
            <td style="width:18%; background:#F3AF23; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Barang Keluar</div>
                <div style="font-size:20px; font-weight:bold;">{{ $summary['aktivitas_keluar'] }}</div>
                <small>Aktivitas transaksi</small>
            </td>
            <td style="width:2%;"></td>
            <td style="width:20%; background:#248AFD; color:white; padding:8px; text-align:center; border-radius:4px;">
                <div style="font-size:10px;">Nilai Total Masuk</div>
                <div style="font-size:13px; font-weight:bold;">Rp
                    {{ number_format($summary['nilai_total_masuk'], 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    {{-- Tabel 1: Stok Barang --}}
    <h4>1. Data Stok Barang</h4>
    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Min Stok</th>
                <th class="text-center">Harga Satuan</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $i => $b)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $b->kode_barang }}</td>
                    <td class="text-center">{{ $b->nama_barang }}</td>
                    <td class="text-center">{{ $b->kategori->nama }}</td>
                    <td class="text-center">{{ $b->satuan }}</td>
                    <td class="text-center {{ $b->isStokMenipis() ? 'text-danger' : 'text-success' }}">
                        {{ $b->stok }}
                    </td>
                    <td class="text-center">{{ $b->stok_minimum }}</td>
                    <td class="text-left">Rp {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if ($b->isStokMenipis())
                            <span class="badge badge-warning">Menipis</span>
                        @else
                            <span class="badge badge-success">Aman</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tabel 2: Barang Masuk --}}
    @if ($masuk->count() > 0)
        <h4>2. Riwayat Barang Masuk ({{ $masuk->count() }} transaksi)</h4>
        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Barang</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Harga Satuan</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Supplier</th>
                    <th class="text-center">Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($masuk as $i => $m)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-center">{{ $m->tanggal_masuk->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $m->barang->nama_barang }}</td>
                        <td class="text-center">{{ $m->barang->kategori->nama }}</td>
                        <td class="text-center">{{ $m->jumlah }} {{ $m->barang->satuan }}</td>
                        <td class="text-left">Rp {{ number_format($m->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-left">Rp {{ number_format($m->jumlah * $m->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $m->supplier ?? '-' }}</td>
                        <td class="text-center">{{ $m->user->name }}</td>
                    </tr>
                @endforeach
                <tr style="background:#e8f5e9; font-weight:bold;">
                    <td colspan="4" class="text-right">Total Nilai Pembelian:</td>
                    <td class="text-center">Rp {{ number_format($summary['nilai_total_masuk'], 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- Tabel 3: Barang Keluar --}}
    @if ($keluar->count() > 0)
        <h4>3. Riwayat Barang Keluar ({{ $keluar->count() }} transaksi)</h4>
        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Barang</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Keperluan</th>
                    <th class="text-center">Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keluar as $i => $k)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-center">{{ $k->tanggal_keluar->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $k->barang->nama_barang }}</td>
                        <td class="text-center">{{ $k->barang->kategori->nama }}</td>
                        <td class="text-center">{{ $k->jumlah }} {{ $k->barang->satuan }}</td>
                        <td class="text-center">{{ $k->keperluan ?? '-' }}</td>
                        <td class="text-center">{{ $k->user->name }}</td>
                    </tr>
                @endforeach
                <tr style="background:#fff3cd; font-weight:bold;">
                    <td colspan="4" class="text-right">Total Penggunaan Barang:</td>
                    <td class="text-center">{{ $summary['aktivitas_keluar'] }} Transaksi</td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- Footer --}}
    <div class="footer">
        Peternakan Sumber Makmur &nbsp;|&nbsp;
        Dicetak oleh: {{ auth()->user()->name }} &nbsp;|&nbsp;
        {{ now()->translatedFormat('d F Y H:i') }}
    </div>

</body>

</html>
