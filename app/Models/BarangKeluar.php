<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $barang_id
 * @property int $jumlah
 * @property \Illuminate\Support\Carbon $tanggal_keluar
 * @property string|null $keperluan
 * @property string|null $keterangan
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barang $barang
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar query()
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar whereKeperluan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar whereTanggalKeluar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BarangKeluar whereUserId($value)
 * @mixin \Eloquent
 */
class BarangKeluar extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_barang_keluar';

    protected $table = 'barang_keluar';

    protected $fillable = [
        'barang_id',
        'jumlah',
        'tanggal_keluar',
        'keperluan',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
        'jumlah'         => 'integer',
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
}
