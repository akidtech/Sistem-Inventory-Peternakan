<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriInventory;
use Illuminate\Http\Request;

class InventoryBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $barang = Barang::with('kategori')

            // Search
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('nama_barang', 'like', '%' . $request->search . '%')
                        ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
                });
            })

            // Filter kategori
            ->when($request->kategori, function ($q) use ($request) {
                $q->whereHas('kategori', function ($query) use ($request) {
                    $query->where('nama', $request->kategori);
                });
            })

            ->oldest()
            ->paginate(10)
            ->appends(request()->query());

        return view('inventory.barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = KategoriInventory::all();
        return view('inventory.barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama_barang'  => 'required|string|max:100',
            'kategori_id'  => 'required|exists:kategori_inventory,id_kategori',
            'satuan'       => 'required|string|max:20',
            'stok'         => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        // Prefix kode berdasarkan kategori
        $kategori = KategoriInventory::find($request->kategori_id);
        $prefixMap = [
            'Pakan'   => 'PKN',
            'Obat'    => 'OBT',
            'Vitamin' => 'VIT',
        ];
        $prefix = $prefixMap[$kategori->nama] ?? strtoupper(substr($kategori->nama, 0, 3));

        // Nomor urut per kategori per tahun
        $lastBarang = Barang::where('kategori_id', $request->kategori_id)
            ->whereYear('created_at', date('Y'))
            ->latest('id_barang')
            ->first();

        $nomorUrut = $lastBarang
            ? (intval(substr($lastBarang->kode_barang, -2)) + 1)
            : 1;

        $kode = $prefix . '-' . date('Y') . '-' . str_pad($nomorUrut, 2, '0', STR_PAD_LEFT);

        Barang::create([
            'kode_barang'  => $kode,
            'nama_barang'  => $request->nama_barang,
            'kategori_id'  => $request->kategori_id,
            'satuan'       => $request->satuan,
            'stok'         => $request->stok,
            'stok_minimum' => $request->stok_minimum,
            'harga_satuan' => $request->harga_satuan,
        ]);

        return redirect()->route('inventory.barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Barang $barang)
    {
        $kategori = KategoriInventory::all();
        return view('inventory.barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, Barang $barang)
    {

        $request->validate([
            'nama_barang'  => 'required|string|max:100',
            'kategori_id'  => 'required|exists:kategori_inventory,id_kategori',
            'satuan'       => 'required|string|max:20',
            'stok_minimum' => 'required|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $barang->update([
            'nama_barang'   => $request->nama_barang,
            'kategori_id'   => $request->kategori_id,
            'satuan'        => $request->satuan,
            'stok_minimum'  => $request->stok_minimum,
            'harga_satuan'  => $request->harga_satuan
        ]);

        return redirect()->route('inventory.barang.index')
            ->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('inventory.barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
