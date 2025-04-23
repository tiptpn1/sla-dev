<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direktorat extends Model
{
    use HasFactory;
    protected $table = 'master_direktorat';
    protected $primaryKey = 'direktorat_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    protected $guarded = ['direktorat_id'];

    public function users()
    {
        return $this->hasMany(User::class, 'direktorat_id', 'direktorat_id');
    }

    public function proyek()
    {
        return $this->hasMany(Proyek::class, 'direktorat_id', 'direktorat_id');
    }

}
