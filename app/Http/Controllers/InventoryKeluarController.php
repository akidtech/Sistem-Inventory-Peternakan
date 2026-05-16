<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryKeluarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function kirimNotifikasi(string $judul, string $pesan, string $tipe)
    {
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            \App\Models\Notifikasi::create([
                'user_id'      => $user->id,
                'judul'        => $judul,
                'pesan'        => $pesan,
                'tipe'         => $tipe,
                'sudah_dibaca' => false,
            ]);
        }
    }

    public function index(Request $request)
    {
        $keluar = BarangKeluar::with(['barang.kategori', 'user'])

            // Search
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('barang', function ($query) use ($request) {
                    $query->where('nama_barang', 'like', '%' . $request->search . '%');
                });
            })

            // Filter kategori
            ->when($request->kategori, function ($q) use ($request) {
                $q->whereHas('barang.kategori', function ($query) use ($request) {
                    $query->where('nama', $request->kategori);
                });
            })

            ->oldest()
            ->paginate(10)
            ->appends(request()->query());

        return view('inventory.keluar.index', compact('keluar'));
    }

    public function create()
    {
        $barang = Barang::with('kategori')
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();
        return view('inventory.keluar.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'      => 'required|exists:barang,id',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'keperluan'      => 'nullable|string|max:200',
            'keterangan'     => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        if ($barang->stok < $request->jumlah) {
            return back()->withErrors([
                'jumlah' => "Stok tidak cukup! Stok tersedia: {$barang->stok} {$barang->satuan}"
            ])->withInput();
        }

        DB::transaction(function () use ($request, $barang) {
            BarangKeluar::create([
                'barang_id'      => $request->barang_id,
                'jumlah'         => $request->jumlah,
                'tanggal_keluar' => $request->tanggal_keluar,
                'keperluan'      => $request->keperluan,
                'keterangan'     => $request->keterangan,
                'user_id'        => auth()->id(),
            ]);

            $barang->decrement('stok', $request->jumlah);
            $barang->refresh();

            // Cek stok menipis setelah keluar
            if ($barang->isStokMenipis()) {
                $this->kirimNotifikasi(
                    "Stok {$barang->nama_barang} Menipis!",
                    "Stok {$barang->nama_barang} tinggal {$barang->stok} {$barang->satuan}, di bawah batas minimum {$barang->stok_minimum} {$barang->satuan}. Segera lakukan restock.",
                    'stok_menipis'
                );
            }
        });

        return redirect()->route('inventory.keluar.index')
            ->with('success', 'Barang keluar berhasil dicatat! Stok telah dikurangi.');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::transaction(function () use ($barangKeluar) {
            // Kembalikan stok
            $barangKeluar->barang->increment('stok', $barangKeluar->jumlah);
            $barangKeluar->delete();
        });

        return redirect()->route('inventory.keluar.index')
            ->with('success', 'Data barang keluar berhasil dihapus.');
    }
}
