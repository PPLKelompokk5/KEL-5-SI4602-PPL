<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'employees_id',
        'project_id',
        'location_id',
        'date',
        'timestamp',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}