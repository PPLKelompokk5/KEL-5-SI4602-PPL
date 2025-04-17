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

    public $incrementing = false;
    protected $keyType = 'string';

    public function pdEmployee() 
    {
        return $this->belongsTo(Employee::class, 'pd');
    }

    public function pmEmployee() 
    {
        return $this->belongsTo(Employee::class, 'pm');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    protected static function booted()
    {
        static::creating(function ($project) {
            if ($project->nilai_kontrak !== null && $project->roi_percent !== null) {
                $project->roi_idr = ($project->nilai_kontrak * $project->roi_percent) / 100;
            }

            $prefix = match ($project->type) {
                'Pendampingan' => 'PE',
                'Semi-Pendampingan' => 'SM',
                'Mentoring' => 'MT',
                'Perpetuation' => 'PP',
                default => 'XX',
            };

            $existingIds = static::where('id', 'like', $prefix . '%')->pluck('id')->toArray();
            $usedNumbers = collect($existingIds)
                ->map(fn($id) => intval(substr($id, 2)))
                ->sort()
                ->values();

            for ($i = 1; $i <= 99; $i++) {
                $newId = $prefix . str_pad($i, 2, '0', STR_PAD_LEFT);
                if (!in_array($newId, $existingIds)) {
                    $project->id = $newId;
                    break;
                }
            }
        });

        static::updating(function ($project) {
            if ($project->nilai_kontrak !== null && $project->roi_percent !== null) {
                $project->roi_idr = ($project->nilai_kontrak * $project->roi_percent) / 100;
            }
        });
    }
}