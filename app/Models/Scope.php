<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class Scope extends Model
{
    use HasFactory;

    protected $table = 'scopes';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $guarded = ['id'];

    // public function proyek()
    // {
    //     return $this->belongsTo(Proyek::class, 'project_id');  // Sesuaikan 'project_id' jika nama kolom berbeda
    // }
}
