<?php

namespace App\Http\Controllers;

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
        $totalBarang = Barang::count();
        $stokMenipis = Barang::stokMenurun()->count();
        $notifBelumDibaca = Notifikasi::where('user_id', auth()->id())->where('sudah_dibaca', false)->count();

        // ── Nilai Total Inventory ─────────────────
        $nilaiInventory = Barang::sum(
            DB::raw('stok * harga_satuan')
        );

        // ── Barang Hampir Habis ─────────────────
        $barangMenipis = Barang::whereColumn(
            'stok',
            '<=',
            'stok_minimum'
        )
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        // ── Chart: Aktivitas Inventory 7 Hari ──────────
        $inventoryMovement = [];

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = now()->subDays($i);

            $inventoryMovement[] = [
                'tanggal' => $tanggal->translatedFormat('d M'),

                'masuk' => BarangMasuk::whereDate(
                    'tanggal_masuk',
                    $tanggal
                )->count(),

                'keluar' => BarangKeluar::whereDate(
                    'tanggal_keluar',
                    $tanggal
                )->count(),
            ];
        }

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

        // Gabung & urutkan terbaru
        $aktivitasTerbaru = collect()
            ->merge($barangMasuk)
            ->merge($barangKeluar)
            ->sortByDesc('tanggal')
            ->take(8);

        // ── Notifikasi Terbaru ───────────────────────
        $notifikasi = Notifikasi::where('user_id', auth()->id())
            ->where('sudah_dibaca', false)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBarang',
            'stokMenipis',
            'notifBelumDibaca',
            'nilaiInventory',
            'barangMenipis',
            'inventoryMovement',
            'stokPerKategori',
            'aktivitasTerbaru',
            'notifikasi',
        ));
    }
}
