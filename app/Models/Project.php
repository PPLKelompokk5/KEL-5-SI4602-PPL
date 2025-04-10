<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'start', 'end', 'pd', 'pm', 'type',
        'nilai_kontrak', 'roi_percent', 'status',
    ];

    public function projectDirector()
    {
        return $this->belongsTo(Employee::class, 'pd');
    }

    public function projectManager()
    {
        return $this->belongsTo(Employee::class, 'pm');
    }
}