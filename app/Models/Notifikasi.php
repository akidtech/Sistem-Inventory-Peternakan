<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $judul
 * @property string $pesan
 * @property string $tipe
 * @property bool $sudah_dibaca
 * @property string|null $notifiable_type
 * @property int|null $notifiable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent|null $notifiable
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi belumDibaca()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi wherePesan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi whereSudahDibaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi whereTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifikasi whereUserId($value)
 * @mixin \Eloquent
 */
class Notifikasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_notifikasi';

    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'tipe',
        'sudah_dibaca',
        'notifiable_id',
        'notifiable_type',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id_user'
        );
    }

    // Scopes
    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }

    // Helper
    public function tandaiDibaca(): void
    {
        $this->update(['sudah_dibaca' => true]);
    }
}
