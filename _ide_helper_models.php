<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
	class Barang extends \Eloquent {}
}

namespace App\Models{
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
	class BarangKeluar extends \Eloquent {}
}

namespace App\Models{
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
	class BarangMasuk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $periode
 * @property \Illuminate\Support\Carbon $tanggal_proses
 * @property string $metode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HasilSpkDetail> $detail
 * @property-read int|null $detail_count
 * @property-read \App\Models\HasilSpkDetail|null $terbaikDetail
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpk query()
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpk whereMetode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpk wherePeriode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpk whereTanggalProses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpk whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class HasilSpk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $hasil_spk_id
 * @property int $ternak_id
 * @property array|null $concordance_index
 * @property array|null $discordance_index
 * @property float|null $concordance_dominan
 * @property float|null $discordance_dominan
 * @property int $ranking
 * @property string $status_rekomendasi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $status_label
 * @property-read \App\Models\HasilSpk $hasilSpk
 * @property-read \App\Models\Ternak $ternak
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereConcordanceDominan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereConcordanceIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereDiscordanceDominan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereDiscordanceIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereHasilSpkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereStatusRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereTernakId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HasilSpkDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class HasilSpkDetail extends \Eloquent {}
}

namespace App\Models{
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
	class KategoriInventory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kode_kriteria
 * @property string $nama_kriteria
 * @property float $bobot
 * @property string $tipe
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenilaianSpk> $penilaian
 * @property-read int|null $penilaian_count
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk query()
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk whereBobot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk whereKodeKriteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk whereNamaKriteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk whereTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KriteriaSpk whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class KriteriaSpk extends \Eloquent {}
}

namespace App\Models{
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
	class Notifikasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $ternak_id
 * @property int $kriteria_id
 * @property float $nilai_asli
 * @property int $nilai_konversi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KriteriaSpk $kriteria
 * @property-read \App\Models\Ternak $ternak
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk query()
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk whereKriteriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk whereNilaiAsli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk whereNilaiKonversi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk whereTernakId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenilaianSpk whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PenilaianSpk extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HasilSpkDetail> $hasilSpkDetail
 * @property-read int|null $hasil_spk_detail_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notifikasi> $notifikasi
 * @property-read int|null $notifikasi_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenilaianSpk> $penilaian
 * @property-read int|null $penilaian_count
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
	class Ternak extends \Eloquent {}
}

namespace App\Models{
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
	class User extends \Eloquent {}
}

