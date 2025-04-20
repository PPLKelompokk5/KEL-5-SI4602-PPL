<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class McsRoi extends Model
{
    use HasFactory;

    protected $table = 'mcs_roi';

    protected $fillable = [
        'project_id',
        'indicator',
        'harga',
        'target',
        'uom',
        'target_idr',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}