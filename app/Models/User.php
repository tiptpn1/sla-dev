<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'master_user';
    protected $primaryKey = 'master_user_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'master_nama_bagian_id',
        'master_user_nama',
        'master_user_password',
        'master_hak_akses_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'master_user_password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'master_user_password' => 'hashed',
    ];

    // Tentukan kolom yang digunakan untuk autentikasi
    public function getAuthPassword()
    {
        return $this->master_user_password;
    }

    // Tentukan kolom yang digunakan untuk autentikasi
    public function getAuthIdentifierName()
    {
        return $this->master_user_nama;
    }

    public function bagian()
    {
        return $this->belongsTo(Bagian::class, 'master_nama_bagian_id', 'master_bagian_id');
    }

    public function hakAkses()
    {
        return $this->belongsTo(HakAkses::class, 'master_hak_akses_id', 'hak_akses_id');
    }

    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class, 'direktorat_id', 'direktorat_id');
    }

    public function sub_bagian()
    {
        return $this->belongsTo(SubBagian::class, 'id_sub_divisi', 'id');
    }
}
