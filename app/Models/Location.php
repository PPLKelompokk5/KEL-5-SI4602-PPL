<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['project_id', 'name'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}