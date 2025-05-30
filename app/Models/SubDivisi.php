<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDivisi extends Model
{
    use HasFactory;
    protected $table = 'master_sub_bagian';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $fillable = [
        'sub_bagian_nama',
        'sub_bagian_kode',
        'master_bagian_id',
        'direktorat_id',
    ];

    public function bagian()
    {
        return $this->belongsTo(Bagian::class, 'master_bagian_id', 'master_bagian_id');
    }
    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class, 'direktorat_id', 'direktorat_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_sub_divisi', 'id_sub_divisi');
    }

    public function scopes()
    {
        return $this->hasMany(Proyek::class, 'sub_bagian_id', 'sub_bagian_id');
    }

}
