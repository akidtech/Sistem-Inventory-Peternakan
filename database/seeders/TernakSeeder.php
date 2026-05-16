<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ternak;

class TernakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ternak = [
            // ── SAPI (SAP) ──────────────────────────────
            [
                'kode_ternak'    => 'SAP-2026-001',
                'nama'           => 'Limousin 1',
                'jenis'          => 'limousin',
                'jenis_kelamin'  => 'jantan',
                'berat'          => 320,
                'umur'           => 24,
                'kesehatan'      => 'sangat_sehat',
                'kondisi_fisik'  => 'baik',
                'harga_beli'     => 25000000,
                'harga_jual'     => 38000000,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2026-01-10',
                'keterangan'     => null,
                'user_id'        => 1,
            ],
            [
                'kode_ternak'    => 'SAP-2026-002',
                'nama'           => 'Simental 1',
                'jenis'          => 'simental',
                'jenis_kelamin'  => 'jantan',
                'berat'          => 290,
                'umur'           => 20,
                'kesehatan'      => 'sehat',
                'kondisi_fisik'  => 'baik',
                'harga_beli'     => 20000000,
                'harga_jual'     => 28000000,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2026-01-15',
                'keterangan'     => null,
                'user_id'        => 1,
            ],
            [
                'kode_ternak'    => 'SAP-2026-003',
                'nama'           => 'PO 1',
                'jenis'          => 'po',
                'jenis_kelamin'  => 'jantan',
                'berat'          => 260,
                'umur'           => 30,
                'kesehatan'      => 'sangat_sehat',
                'kondisi_fisik'  => 'baik',
                'harga_beli'     => 21000000,
                'harga_jual'     => 30000000,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2026-01-20',
                'keterangan'     => null,
                'user_id'        => 1,
            ],
            [
                'kode_ternak'    => 'SAP-2026-004',
                'nama'           => 'Brahman 1',
                'jenis'          => 'brahman',
                'jenis_kelamin'  => 'betina',
                'berat'          => 240,
                'umur'           => 18,
                'kesehatan'      => 'sehat',
                'kondisi_fisik'  => 'baik',
                'harga_beli'     => 19000000,
                'harga_jual'     => 26000000,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2026-02-01',
                'keterangan'     => null,
                'user_id'        => 2,
            ],

            // ── KAMBING (KMB) ───────────────────────────
            [
                'kode_ternak'    => 'KMB-2026-001',
                'nama'           => 'Etawa 1',
                'jenis'          => 'etawa',
                'jenis_kelamin'  => 'betina',
                'berat'          => 45,
                'umur'           => 18,
                'kesehatan'      => 'sangat_sehat',
                'kondisi_fisik'  => 'baik',
                'harga_beli'     => 3500000,
                'harga_jual'     => 5000000,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2026-01-12',
                'keterangan'     => null,
                'user_id'        => 1,
            ],
            [
                'kode_ternak'    => 'KMB-2026-002',
                'nama'           => 'Boer 1',
                'jenis'          => 'boer',
                'jenis_kelamin'  => 'jantan',
                'berat'          => 60,
                'umur'           => 24,
                'kesehatan'      => 'sehat',
                'kondisi_fisik'  => 'baik',
                'harga_beli'     => 4500000,
                'harga_jual'     => 6500000,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2026-01-18',
                'keterangan'     => null,
                'user_id'        => 1,
            ],
            [
                'kode_ternak'    => 'KMB-2026-003',
                'nama'           => 'Kacang 1',
                'jenis'          => 'kacang',
                'jenis_kelamin'  => 'jantan',
                'berat'          => 30,
                'umur'           => 12,
                'kesehatan'      => 'sehat',
                'kondisi_fisik'  => 'cukup',
                'harga_beli'     => 2000000,
                'harga_jual'     => 3000000,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2026-02-05',
                'keterangan'     => null,
                'user_id'        => 2,
            ],
            [
                'kode_ternak'    => 'KMB-2026-004',
                'nama'           => 'Jawarandu 1',
                'jenis'          => 'jawarandu',
                'jenis_kelamin'  => 'betina',
                'berat'          => 50,
                'umur'           => 20,
                'kesehatan'      => 'sangat_sehat',
                'kondisi_fisik'  => 'baik',
                'harga_beli'     => 3800000,
                'harga_jual'     => 5500000,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2026-02-10',
                'keterangan'     => null,
                'user_id'        => 2,
            ],
            [
                'kode_ternak'    => 'KMB-2026-005',
                'nama'           => 'Saanen 1',
                'jenis'          => 'saanen',
                'jenis_kelamin'  => 'betina',
                'berat'          => 40,
                'umur'           => 15,
                'kesehatan'      => 'cukup',
                'kondisi_fisik'  => 'cukup',
                'harga_beli'     => 3000000,
                'harga_jual'     => 4200000,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2026-02-15',
                'keterangan'     => null,
                'user_id'        => 1,
            ],
        ];

        foreach ($ternak as $t) {
            Ternak::create($t);
        }
    }
}
