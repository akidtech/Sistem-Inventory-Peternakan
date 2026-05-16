<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = [
            // Pakan (kategori_id: 1)
            [
                'kode_barang'   => 'PKN-001',
                'nama_barang'   => 'Rumput Gajah',
                'kategori_id'   => 1,
                'satuan'        => 'kg',
                'stok'          => 500,
                'stok_minimum'  => 100,
                'harga_satuan'  => 2000,
            ],
            [
                'kode_barang'   => 'PKN-002',
                'nama_barang'   => 'Konsentrat Sapi',
                'kategori_id'   => 1,
                'satuan'        => 'kg',
                'stok'          => 200,
                'stok_minimum'  => 50,
                'harga_satuan'  => 8500,
            ],
            [
                'kode_barang'   => 'PKN-003',
                'nama_barang'   => 'Dedak Padi',
                'kategori_id'   => 1,
                'satuan'        => 'kg',
                'stok'          => 300,
                'stok_minimum'  => 75,
                'harga_satuan'  => 3500,
            ],
            // Obat (kategori_id: 2)
            [
                'kode_barang'   => 'OBT-001',
                'nama_barang'   => 'Obat Cacing',
                'kategori_id'   => 2,
                'satuan'        => 'botol',
                'stok'          => 30,
                'stok_minimum'  => 10,
                'harga_satuan'  => 45000,
            ],
            [
                'kode_barang'   => 'OBT-002',
                'nama_barang'   => 'Antibiotik Ternak',
                'kategori_id'   => 2,
                'satuan'        => 'botol',
                'stok'          => 15,
                'stok_minimum'  => 5,
                'harga_satuan'  => 85000,
            ],
            // Vitamin (kategori_id: 3)
            [
                'kode_barang'   => 'VIT-001',
                'nama_barang'   => 'Vitamin B Kompleks',
                'kategori_id'   => 3,
                'satuan'        => 'botol',
                'stok'          => 25,
                'stok_minimum'  => 8,
                'harga_satuan'  => 55000,
            ],
            [
                'kode_barang'   => 'VIT-002',
                'nama_barang'   => 'Mineral Mix',
                'kategori_id'   => 3,
                'satuan'        => 'kg',
                'stok'          => 40,
                'stok_minimum'  => 10,
                'harga_satuan'  => 35000,
            ],
        ];

        foreach ($barang as $b) {
            Barang::create($b);
        }
    }
}
