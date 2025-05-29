<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $fillable = [
        'project_id',
        'indikator',
        'uom',
        'target',
        'base',
        'bulan',
        'level_1',
        'level_2',
        'level_3',
        'level_4',
        'level_5',
        'level_6',
        'level_7',
        'level_8',
        'level_9',
        'level_10',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}