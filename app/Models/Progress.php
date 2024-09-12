<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $table = 'detail_progress';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $guarded = ['id'];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id_activity');
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class, 'progress_id', 'id');
    }
}
