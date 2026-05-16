<?php

namespace App\Http\Controllers;

use App\Models\Ternak;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // ── Stat Cards ──────────────────────────────
        $totalTernak    = Ternak::count();
        $totalBarang = Barang::count();
        $stokMenipis = Barang::stokMenurun()->count();
        $notifBelumDibaca = Notifikasi::where('user_id', auth()->id())->where('sudah_dibaca', false)->count();
        // ── Chart: Ternak per Jenis (Pie) ───────────
        $sapi = Ternak::whereIn('jenis', [
            'limousin',
            'simental',
            'po',
            'angus',
            'brahman',
            'bali',
            'madura',
            'friesian_holstein'
        ])->count();

        $kambing = Ternak::whereIn('jenis', [
            'etawa',
            'boer',
            'kacang',
            'jawarandu',
            'saanen'
        ])->count();

        $ternakPerJenis = [
            'Sapi' => $sapi,
            'Kambing' => $kambing
        ];

        // ── Chart: Barang Masuk dan Keluar (Bar) ──────────
        $inventoryMovement = [
            'Masuk'  => BarangMasuk::count(),
            'Keluar' => BarangKeluar::count(),
        ];

        // ── Chart: Stok Inventory per Kategori ──────
        $stokPerKategori = Barang::with('kategori')
            ->select('kategori_id', DB::raw('sum(stok) as total_stok'))
            ->groupBy('kategori_id')
            ->get()
            ->mapWithKeys(fn($b) => [$b->kategori->nama ?? '-' => $b->total_stok]);

        // ── Tabel: 5 Riwayat Aktivitas ──────────────────
        // Barang masuk terbaru
        $barangMasuk = BarangMasuk::with('barang')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->created_at,
                    'aktivitas' => 'Barang Masuk',
                    'detail' => $item->barang->nama_barang . ' +' . $item->jumlah . ' ' . $item->barang->satuan,
                    'badge' => 'success'
                ];
            });

        // Barang keluar terbaru
        $barangKeluar = BarangKeluar::with('barang')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->created_at,
                    'aktivitas' => 'Barang Keluar',
                    'detail' => $item->barang->nama_barang . ' -' . $item->jumlah . ' ' . $item->barang->satuan,
                    'badge' => 'danger'
                ];
            });

        // Ternak baru
        $ternakBaru = Ternak::latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->created_at,
                    'aktivitas' => 'Ternak Baru',
                    'detail' => $item->nama . ' (' . $item->kode_ternak . ') ditambahkan',
                    'badge' => 'info'
                ];
            });

        // Ternak terjual
        $ternakTerjual = Ternak::where('status', 'terjual')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->updated_at,
                    'aktivitas' => 'Ternak Terjual',
                    'detail' => $item->nama . ' (' . $item->kode_ternak . ') berhasil terjual',
                    'badge' => 'warning'
                ];
            });

        // Gabung & urutkan terbaru
        $aktivitasTerbaru = collect()
            ->merge($barangMasuk)
            ->merge($barangKeluar)
            ->merge($ternakBaru)
            ->merge($ternakTerjual)
            ->sortByDesc('tanggal')
            ->take(8);

        // ── Notifikasi Terbaru ───────────────────────
        $notifikasi = Notifikasi::where('user_id', auth()->id())
            ->where('sudah_dibaca', false)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalTernak',
            'totalBarang',
            'stokMenipis',
            'notifBelumDibaca',
            'ternakPerJenis',
            'inventoryMovement',
            'stokPerKategori',
            'aktivitasTerbaru',
            'notifikasi',
        ));
    }
}
