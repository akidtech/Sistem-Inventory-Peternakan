<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $kode_ternak
 * @property string $nama
 * @property string $jenis
 * @property float $berat
 * @property int $umur
 * @property string $kesehatan
 * @property string $kondisi_fisik
 * @property string $harga_beli
 * @property string|null $harga_jual
 * @property string $status
 * @property \Illuminate\Support\Carbon $tanggal_masuk
 * @property string|null $keterangan
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $keuntungan
 * @property-read string $status_label
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notifikasi> $notifikasi
 * @property-read int|null $notifikasi_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak aktif()
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak siapJual()
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereBerat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereHargaBeli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereHargaJual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereKesehatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereKodeTernak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereKondisiFisik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereTanggalMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereUmur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ternak whereUserId($value)
 * @mixin \Eloquent
 */
class Ternak extends Model
{
    use HasFactory;

    protected $table = 'ternak';

    protected $fillable = [
        'kode_ternak',
        'nama',
        'jenis',
        'jenis_kelamin',
        'berat',
        'umur',
        'kesehatan',
        'kondisi_fisik',
        'harga_beli',
        'harga_jual',
        'status',
        'tanggal_masuk',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'harga_beli'    => 'decimal:2',
        'harga_jual'    => 'decimal:2',
        'berat'         => 'float',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function notifikasi()
    {
        return $this->morphMany(Notifikasi::class, 'notifiable');
    }

    // Accessors
    public function getKeuntunganAttribute(): float
    {
        return ($this->harga_jual ?? 0) - $this->harga_beli;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'aktif'     => 'Aktif',
            'siap_jual' => 'Siap Dijual',
            'terjual'   => 'Terjual',
            default     => '-',
        };
    }

    // Scopes
    public function scopeSiapJual($query)
    {
        return $query->where('status', 'siap_jual');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
