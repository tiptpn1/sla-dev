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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_activity',
        'plan_start',
        'plan_duration',
        'actual_start',
        'actual_duration',
        'percent_complete',
        'scope_id',
        'project_id',
        'isActive',
    ];

    protected $guarded = ['id_activity'];

    protected $attributes = [
        'percent_complete' => 0,
    ];

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

    public function scope()
    {
        return $this->belongsTo(Scope::class, 'scope_id', 'id');
    }
}
