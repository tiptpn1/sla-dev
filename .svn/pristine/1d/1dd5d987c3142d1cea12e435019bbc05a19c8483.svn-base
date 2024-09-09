<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activity';
    protected $primaryKey = 'id_activity';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $guarded = ['id_activity'];

    public function pics()
    {
        return $this->hasMany(Pic::class, 'activity_id', 'id_activity');
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'project_id', 'id_project');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'activity_id', 'id_activity');
    }
}
