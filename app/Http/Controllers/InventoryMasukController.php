<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryMasukController extends Controller
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
        $masuk = BarangMasuk::with(['barang.kategori', 'user'])

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

        return view('inventory.masuk.index', compact('masuk'));
    }

    public function create()
    {
        $barang = Barang::with('kategori')->orderBy('nama_barang')->get();
        return view('inventory.masuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'     => 'required|exists:barang,id',
            'jumlah'        => 'required|integer|min:1',
            'harga_satuan'  => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'supplier'      => 'nullable|string|max:100',
            'keterangan'    => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            BarangMasuk::create([
                'barang_id'     => $request->barang_id,
                'jumlah'        => $request->jumlah,
                'harga_satuan'  => $request->harga_satuan,
                'tanggal_masuk' => $request->tanggal_masuk,
                'supplier'      => $request->supplier,
                'keterangan'    => $request->keterangan,
                'user_id'       => auth()->id(),
            ]);

            $barang = Barang::find($request->barang_id);
            $barang->increment('stok', $request->jumlah);
            $barang->refresh();

            // Notifikasi barang masuk ke semua user
            $this->kirimNotifikasi(
                'Barang Masuk',
                "Stok {$barang->nama_barang} bertambah {$request->jumlah} {$barang->satuan}. Total stok: {$barang->stok} {$barang->satuan}.",
                'barang_masuk'
            );

            // Cek stok menipis setelah update
            if ($barang->isStokMenipis()) {
                $this->kirimNotifikasi(
                    "Stok {$barang->nama_barang} Menipis!",
                    "Stok {$barang->nama_barang} tinggal {$barang->stok} {$barang->satuan}, di bawah batas minimum {$barang->stok_minimum} {$barang->satuan}. Segera lakukan restock.",
                    'stok_menipis'
                );
            }
        });

        return redirect()->route('inventory.masuk.index')
            ->with('success', 'Barang masuk berhasil dicatat! Stok telah diperbarui.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function () use ($barangMasuk) {
            // Kurangi stok kembali
            $barangMasuk->barang->decrement('stok', $barangMasuk->jumlah);
            $barangMasuk->delete();
        });

        return redirect()->route('inventory.masuk.index')
            ->with('success', 'Data barang masuk berhasil dihapus.');
    }
}
