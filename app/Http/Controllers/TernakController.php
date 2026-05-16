<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ternak;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TernakController extends Controller
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

    // ── Index: Daftar semua ternak ─────────────────
    public function index(Request $request)
    {
        $jenisSapi = [
            'limousin',
            'simental',
            'po',
            'angus',
            'brahman',
            'bali',
            'madura',
            'friesian_holstein'
        ];

        $jenisKambing = [
            'etawa',
            'boer',
            'kacang',
            'jawarandu',
            'saanen'
        ];

        $ternak = Ternak::query()

            // Search
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->search . '%')
                        ->orWhere('kode_ternak', 'like', '%' . $request->search . '%');
                });
            })

            // Filter sapi / kambing
            ->when($request->hewan == 'sapi', function ($q) use ($jenisSapi) {
                $q->whereIn('jenis', $jenisSapi);
            })

            ->when($request->hewan == 'kambing', function ($q) use ($jenisKambing) {
                $q->whereIn('jenis', $jenisKambing);
            })

            ->orderBy('id', 'asc')
            ->paginate(10)
            ->appends(request()->query());

        return view('ternak.index', compact('ternak'));
    }

    // ── Create: Form tambah ternak ─────────────────
    public function create()
    {
        return view('ternak.create');
    }

    // ── Store: Simpan ternak baru ──────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'jenis'         => 'required|in:limousin,simental,po,angus,brahman,bali,madura,friesian_holstein,etawa,boer,kacang,jawarandu,saanen,lainnya',
            'berat'         => 'required|numeric|min:1',
            'umur'          => 'required|integer|min:1',
            'kesehatan'     => 'required|in:sangat_sehat,sehat,cukup_sehat,kurang_sehat,tidak_sehat',
            'kondisi_fisik' => 'required|in:sangat_baik,baik,cukup,kurang,buruk',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'nullable|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'keterangan'    => 'nullable|string',
        ], [
            'nama.required'          => 'Nama ternak wajib diisi.',
            'jenis.required'         => 'Jenis ternak wajib dipilih.',
            'berat.required'         => 'Berat ternak wajib diisi.',
            'umur.required'          => 'Umur ternak wajib diisi.',
            'kesehatan.required'     => 'Status kesehatan wajib dipilih.',
            'kondisi_fisik.required' => 'Kondisi fisik wajib dipilih.',
            'harga_beli.required'    => 'Harga beli wajib diisi.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
        ]);

        // Generate kode ternak otomatis berdasarkan jenis
        $sapiList   = ['limousin', 'simental', 'po', 'angus', 'brahman', 'bali', 'madura', 'friesian_holstein'];
        $kambingList = ['etawa', 'boer', 'kacang', 'jawarandu', 'saanen'];

        if (in_array($request->jenis, $sapiList)) {
            $prefix = 'SAP';
        } elseif (in_array($request->jenis, $kambingList)) {
            $prefix = 'KMB';
        } else {
            $prefix = 'TRN';
        }

        // Hitung nomor urut per prefix per tahun
        $lastTernak = Ternak::whereYear('created_at', date('Y'))
            ->where('kode_ternak', 'like', $prefix . '-' . date('Y') . '-%')
            ->latest('id')
            ->first();

        $nomorUrut = $lastTernak
            ? (intval(substr($lastTernak->kode_ternak, -3)) + 1)
            : 1;

        $kode = $prefix . '-' . date('Y') . '-' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        Ternak::create([
            'kode_ternak'   => $kode,
            'nama'          => $request->nama,
            'jenis'         => $request->jenis,
            'berat'         => $request->berat,
            'umur'          => $request->umur,
            'kesehatan'     => $request->kesehatan,
            'kondisi_fisik' => $request->kondisi_fisik,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'status'        => 'aktif',
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan'    => $request->keterangan,
            'user_id'       => auth()->id(),
        ]);

        return redirect()->route('ternak.index')
            ->with('success', "Ternak {$request->nama} berhasil ditambahkan! ✅");
    }

    // ── Show: Detail ternak ────────────────────────
    public function show(Ternak $ternak)
    {
        return view('ternak.show', compact('ternak'));
    }

    // ── Edit: Form edit ternak ─────────────────────
    public function edit(Ternak $ternak)
    {
        return view('ternak.edit', compact('ternak'));
    }

    // ── Update: Simpan perubahan ───────────────────
    public function update(Request $request, Ternak $ternak)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'jenis'         => 'required|in:limousin,simental,po,angus,brahman,bali,madura,friesian_holstein,etawa,boer,kacang,jawarandu,saanen,lainnya',
            'berat'         => 'required|numeric|min:1',
            'umur'          => 'required|integer|min:1',
            'kesehatan'     => 'required|in:sangat_sehat,sehat,cukup_sehat,kurang_sehat,tidak_sehat',
            'kondisi_fisik' => 'required|in:sangat_baik,baik,cukup,kurang,buruk',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'nullable|numeric|min:0',
            'status'        => 'required|in:aktif,siap_jual,terjual',
            'tanggal_masuk' => 'required|date',
            'keterangan'    => 'nullable|string',
        ]);

        $statusLama = $ternak->status;

        $ternak->update([
            'nama'          => $request->nama,
            'jenis'         => $request->jenis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'berat'         => $request->berat,
            'umur'          => $request->umur,
            'kesehatan'     => $request->kesehatan,
            'kondisi_fisik' => $request->kondisi_fisik,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'status'        => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan'    => $request->keterangan,
        ]);

        // Notifikasi kalau status berubah jadi terjual
        if ($statusLama !== 'terjual' && $request->status === 'terjual') {
            $keuntungan = ($ternak->harga_jual ?? 0) - $ternak->harga_beli;
            $this->kirimNotifikasi(
                "Ternak {$ternak->nama} Terjual!",
                "{$ternak->nama} ({$ternak->kode_ternak}) berhasil terjual dengan harga Rp " . number_format($ternak->harga_jual, 0, ',', '.') . ". Keuntungan: Rp " . number_format($keuntungan, 0, ',', '.'),
                'ternak_terjual'
            );
        }

        return redirect()->route('ternak.index')
            ->with('success', "Data ternak {$ternak->nama} berhasil diperbarui! ✅");
    }

    // ── Destroy: Hapus ternak ──────────────────────
    public function destroy(Ternak $ternak)
    {
        $nama = $ternak->nama;
        $ternak->delete();

        return redirect()->route('ternak.index')
            ->with('success', "Ternak {$nama} berhasil dihapus.");
    }
}
