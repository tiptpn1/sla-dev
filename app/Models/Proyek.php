<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $table = 'master_project';
    protected $primaryKey = 'id_project';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'project_nama',
        'is_active'
    ];

    protected $guarded = ['id_project'];

    /**
     * Get all of the activities for the Proyek
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class, 'project_id', 'id_project');
    }

    public function scopes()
    {
        return $this->hasMany(Scope::class, 'project_id', 'id_project');
    }
}
