<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $kode_barang
 * @property string $nama_barang
 * @property int $kategori_id
 * @property string $satuan
 * @property int $stok
 * @property int $stok_minimum
 * @property string $harga_satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BarangKeluar> $barangKeluar
 * @property-read int|null $barang_keluar_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BarangMasuk> $barangMasuk
 * @property-read int|null $barang_masuk_count
 * @property-read \App\Models\KategoriInventory $kategori
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notifikasi> $notifikasi
 * @property-read int|null $notifikasi_count
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang stokMenurun()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereStokMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'satuan',
        'stok',
        'stok_minimum',
        'harga_satuan',
    ];

    protected $casts = [
        'stok'         => 'integer',
        'stok_minimum' => 'integer',
        'harga_satuan' => 'decimal:2',
    ];

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(KategoriInventory::class, 'kategori_id');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }

    public function notifikasi()
    {
        return $this->morphMany(Notifikasi::class, 'notifiable');
    }

    // Scopes
    public function scopeStokMenurun($query)
    {
        return $query->whereColumn('stok', '<=', 'stok_minimum');
    }

    // Helper
    public function isStokMenipis(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }
}
