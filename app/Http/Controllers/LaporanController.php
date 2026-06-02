<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── Laporan Inventory ──────────────────────────
    public function inventory(Request $request)
    {
        $barang = Barang::with('kategori')->get();

        $masuk = BarangMasuk::with(['barang.kategori', 'user'])
            ->when($request->dari,   fn($q) => $q->whereDate('tanggal_masuk', '>=', $request->dari))
            ->when($request->sampai, fn($q) => $q->whereDate('tanggal_masuk', '<=', $request->sampai))
            ->latest()->get();

        $keluar = BarangKeluar::with(['barang.kategori', 'user'])
            ->when($request->dari,   fn($q) => $q->whereDate('tanggal_keluar', '>=', $request->dari))
            ->when($request->sampai, fn($q) => $q->whereDate('tanggal_keluar', '<=', $request->sampai))
            ->latest()->get();

        $summary = [
            'total_barang'     => $barang->count(),
            'stok_menipis'     => $barang->filter(fn($b) => $b->isStokMenipis())->count(),
            'aktivitas_masuk'   => $masuk->count(),
            'aktivitas_keluar'  => $keluar->count(),
            'nilai_total_masuk' => $masuk->sum(fn($m) => $m->jumlah * $m->harga_satuan),
        ];

        return view('laporan.inventory', compact('barang', 'masuk', 'keluar', 'summary', 'request'));
    }

    public function inventoryPdf(Request $request)
    {
        $barang = Barang::with('kategori')->get();

        $masuk = BarangMasuk::with(['barang.kategori', 'user'])
            ->when($request->dari,   fn($q) => $q->whereDate('tanggal_masuk', '>=', $request->dari))
            ->when($request->sampai, fn($q) => $q->whereDate('tanggal_masuk', '<=', $request->sampai))
            ->latest()->get();

        $keluar = BarangKeluar::with(['barang.kategori', 'user'])
            ->when($request->dari,   fn($q) => $q->whereDate('tanggal_keluar', '>=', $request->dari))
            ->when($request->sampai, fn($q) => $q->whereDate('tanggal_keluar', '<=', $request->sampai))
            ->latest()->get();

        $summary = [
            'total_barang'      => $barang->count(),
            'stok_menipis'      => $barang->filter(fn($b) => $b->isStokMenipis())->count(),
            'aktivitas_masuk'   => $masuk->count(),
            'aktivitas_keluar'  => $keluar->count(),
            'nilai_total_masuk' => $masuk->sum(fn($m) => $m->jumlah * $m->harga_satuan),
        ];

        $pdf = Pdf::loadView('laporan.pdf.inventory', compact('barang', 'masuk', 'keluar', 'summary', 'request'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-inventory-' . date('Ymd') . '.pdf');
    }
}
