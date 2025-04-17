<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'start', 'end', 'pd', 'pm', 'type',
        'nilai_kontrak', 'roi_percent', 'roi_idr',
        'client_id', 'status',
    ];

    // Relasi ke Employee untuk PD
    public function pdEmployee() 
    {
        return $this->belongsTo(Employee::class, 'pd');
    }

    // Relasi ke Employee untuk PM
    public function pmEmployee() 
    {
        return $this->belongsTo(Employee::class, 'pm');
    }

    // Relasi ke Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Hitung dan simpan roi_idr otomatis sebelum disimpan
    protected static function booted()
    {
        static::saving(function ($project) {
            if ($project->nilai_kontrak !== null && $project->roi_percent !== null) {
                $project->roi_idr = ($project->nilai_kontrak * $project->roi_percent) / 100;
            }
        });
    }
}