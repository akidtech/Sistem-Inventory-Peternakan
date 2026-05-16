<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriInventory;


class KategoriInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            ['nama' => 'Pakan',   'keterangan' => 'Semua jenis pakan ternak seperti rumput, konsentrat, dll'],
            ['nama' => 'Obat',    'keterangan' => 'Obat-obatan untuk pengobatan ternak'],
            ['nama' => 'Vitamin', 'keterangan' => 'Suplemen dan vitamin untuk kesehatan ternak'],
        ];

        foreach ($kategori as $k) {
            KategoriInventory::create($k);
        }
    }
}
