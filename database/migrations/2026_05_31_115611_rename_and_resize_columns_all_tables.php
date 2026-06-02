<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameAndResizeColumnsAllTables extends Migration
{
    public function up(): void
    {
        // ── USERS ─────────────────────────────────────
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'id_user');
            $table->string('name', 100)->change();
            $table->string('email', 100)->change();
            $table->string('no_hp', 20)->nullable()->change();
            $table->string('alamat', 255)->nullable()->change();
            $table->string('foto', 100)->nullable()->change();
        });

        // ── KATEGORI INVENTORY ────────────────────────
        Schema::table('kategori_inventory', function (Blueprint $table) {
            $table->renameColumn('id', 'id_kategori');
            $table->string('nama', 50)->change();
            $table->string('keterangan', 255)->nullable()->change();
        });

        // ── BARANG ────────────────────────────────────
        Schema::table('barang', function (Blueprint $table) {
            $table->renameColumn('id', 'id_barang');
            $table->string('kode_barang', 20)->change();
            $table->string('nama_barang', 100)->change();
            $table->string('satuan', 20)->change();
        });

        // ── BARANG MASUK ──────────────────────────────
        Schema::table('barang_masuk', function (Blueprint $table) {
            $table->renameColumn('id', 'id_barang_masuk');
            $table->string('supplier', 100)->nullable()->change();
            $table->string('keterangan', 255)->nullable()->change();
        });

        // ── BARANG KELUAR ─────────────────────────────
        Schema::table('barang_keluar', function (Blueprint $table) {
            $table->renameColumn('id', 'id_barang_keluar');
            $table->string('keperluan', 200)->nullable()->change();
            $table->string('keterangan', 255)->nullable()->change();
        });

        // ── NOTIFIKASI ────────────────────────────────
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->renameColumn('id', 'id_notifikasi');
            $table->string('judul', 150)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id_user', 'id');
        });
        Schema::table('kategori_inventory', function (Blueprint $table) {
            $table->renameColumn('id_kategori', 'id');
        });
        Schema::table('barang', function (Blueprint $table) {
            $table->renameColumn('id_barang', 'id');
        });
        Schema::table('barang_masuk', function (Blueprint $table) {
            $table->renameColumn('id_barang_masuk', 'id');
        });
        Schema::table('barang_keluar', function (Blueprint $table) {
            $table->renameColumn('id_barang_keluar', 'id');
        });
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->renameColumn('id_notifikasi', 'id');
        });
    }
}
