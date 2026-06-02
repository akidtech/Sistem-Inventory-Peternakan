<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $barang_id
 * @property int $jumlah
 * @property string $harga_satuan
 * @property \Illuminate\Support\Carbon $tanggal_masuk
 * @property string|null $supplier
 * @property string|null $keterangan
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barang $barang
 * @property-read float $total_harga
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk query()
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereTanggalMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangMasuk whereUserId($value)
 * @mixin \Eloquent
 */
class BarangMasuk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_barang_masuk';

    protected $table = 'barang_masuk';

    protected $fillable = [
        'barang_id',
        'jumlah',
        'harga_satuan',
        'tanggal_masuk',
        'supplier',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'jumlah'        => 'integer',
        'harga_satuan'  => 'decimal:2',
    ];

    // Relationships
    public function barang()
    {
        return $this->belongsTo(
            Barang::class,
            'barang_id',
            'id_barang'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id_user'
        );
    }

    // Accessor
    public function getTotalHargaAttribute(): float
    {
        return $this->jumlah * $this->harga_satuan;
    }
}
