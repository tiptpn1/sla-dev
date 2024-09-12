<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    use HasFactory;
    protected $table = 'master_bagian';
    protected $primaryKey = 'master_bagian_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'master_bagian_insert_at';
    const UPDATED_AT = 'master_bagian_update_at';

    protected $guarded = ['master_bagian_id'];

    public function users()
    {
        return $this->hasMany(User::class, 'master_nama_bagian_id', 'master_bagian_id');
    }

    public function pics()
    {
        return $this->hasMany(Pic::class, 'bagian_id', 'master_bagian_id');
    }
}
