<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use HasFactory;

    protected $table = 'evidence';
    protected $primaryKey = 'id_evidence';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $guarded = ['id_evidence'];

    public function progress()
    {
        return $this->belongsTo(Progress::class, 'progress_id', 'id');
    }
}
