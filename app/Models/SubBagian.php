<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubBagian extends Model
{
    use HasFactory;
    protected $table = 'master_sub_bagian';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;



    protected $guarded = ['id'];
    public function pics()
    {
        return $this->hasMany(Pic::class, 'sub_bagian_id', 'id');
    }
}
