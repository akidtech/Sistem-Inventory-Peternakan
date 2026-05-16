<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'no_hp'    => '081234567890',
            'alamat'   => 'Jl. Peternakan No. 1, Jawa Barat',
        ]);

        User::create([
            'name'     => 'Budi Mulyono',
            'email'    => 'budi@gmail.com',
            'password' => Hash::make('budi123'),
            'role'     => 'peternak',
            'no_hp'    => '082345678901',
            'alamat'   => 'Jl. Kandang Makmur No. 5, Jawa Barat',
        ]);

        User::create([
            'name'     => 'Siti Fatimah',
            'email'    => 'siti@gmail.com',
            'password' => Hash::make('siti123'),
            'role'     => 'peternak',
            'no_hp'    => '083456789012',
            'alamat'   => 'Jl. Padang Rumput No. 12, Jawa Barat',
        ]);
    }
}
