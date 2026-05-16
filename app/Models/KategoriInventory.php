<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Barang> $barang
 * @property-read int|null $barang_count
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriInventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriInventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriInventory query()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriInventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriInventory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriInventory whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriInventory whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriInventory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KategoriInventory extends Model
{
    use HasFactory;

    protected $table = 'kategori_inventory';

    protected $fillable = [
        'nama',
        'keterangan',
    ];

    // Relationships
    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
