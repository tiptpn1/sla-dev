<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
    use HasFactory;

    protected $table = 'pic';
    protected $primaryKey = 'id_pic';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $guarded = ['id_pic'];

    public function bagian()
    {
        return $this->belongsTo(Bagian::class, 'bagian_id', 'master_bagian_id');
    }

    public function subBagian()
    {
        return $this->belongsTo(subBagian::class, 'sub_bagian_id', 'id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id_activity');
    }
}
