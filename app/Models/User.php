<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $no_hp
 * @property string|null $alamat
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BarangKeluar> $barangKeluar
 * @property-read int|null $barang_keluar_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BarangMasuk> $barangMasuk
 * @property-read int|null $barang_masuk_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notifikasi> $notifikasi
 * @property-read int|null $notifikasi_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ternak> $ternak
 * @property-read int|null $ternak_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method bool isAdmin()
 * @method bool isPeternak()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'alamat',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Relationships
    public function barangMasuk()
    {
        return $this->hasMany(
            BarangMasuk::class,
            'user_id',
            'id_user'
        );
    }

    public function barangKeluar()
    {
        return $this->hasMany(
            BarangKeluar::class,
            'user_id',
            'id_user'
        );
    }

    public function notifikasi()
    {
        return $this->hasMany(
            Notifikasi::class,
            'user_id',
            'id_user'
        );
    }

    // Helper
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPeternak(): bool
    {
        return $this->role === 'peternak';
    }
}
