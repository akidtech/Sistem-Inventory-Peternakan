<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE notifikasi
            MODIFY tipe ENUM(
                'stok_menipis',
                'barang_masuk',
                'barang_keluar'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE notifikasi
            MODIFY tipe ENUM(
                'ternak_siap_jual',
                'stok_menipis',
                'barang_masuk',
                'barang_keluar',
                'ternak_terjual'
            ) NOT NULL
        ");
    }
};
