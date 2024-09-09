<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use HasFactory;

    protected $table = 'evidance';
    protected $primaryKey = 'id_evidance';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $guarded = ['id_evidance'];

    public function progress()
    {
        return $this->belongsTo(Progress::class, 'progress_id', 'id');
    }
}
