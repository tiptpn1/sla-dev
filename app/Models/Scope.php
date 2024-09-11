<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    use HasFactory;

    protected $table = 'scopes';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'isActive',
        'project_id'
    ];

    protected $guarded = ['id'];




    public function activities()
    {
        return $this->hasMany(Activity::class, 'scope_id', 'id');
    }


    public function project()
    {
        return $this->belongsTo(Proyek::class, 'project_id', 'id_project');
    }
}
