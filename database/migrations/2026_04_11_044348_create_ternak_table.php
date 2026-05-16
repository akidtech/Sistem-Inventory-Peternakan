<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ternak', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ternak')->unique();
            $table->string('nama');
            $table->enum('jenis', [
                'limousin',
                'simental',
                'po',
                'angus',
                'brahman',
                'bali',
                'madura',
                'friesian_holstein',
                'etawa',
                'boer',
                'kacang',
                'jawarandu',
                'saanen',
                'lainnya',
            ]);
            $table->enum('jenis_kelamin', ['jantan', 'betina']);
            $table->float('berat', 10, 2); // kg
            $table->integer('umur'); // bulan
            $table->enum('kesehatan', ['sangat_sehat', 'sehat', 'cukup', 'kurang_sehat', 'tidak_sehat']);
            $table->enum('kondisi_fisik', ['sangat_baik', 'baik', 'cukup', 'kurang', 'buruk']);
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('harga_jual', 15, 2)->nullable();
            $table->enum('status', ['aktif', 'siap_jual', 'terjual'])->default('aktif');
            $table->date('tanggal_masuk');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ternak');
    }
};
