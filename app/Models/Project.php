<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end',
        'pd',
        'pm',
        'type',
        'nilai_kontrak',
        'roi_percent',
        'roi_idr',
        'client_id',
        'status',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    // Relasi ke employee sebagai PD
    public function pdEmployee()
    {
        return $this->belongsTo(Employee::class, 'pd');
    }

    // Relasi ke employee sebagai PM
    public function pmEmployee()
    {
        return $this->belongsTo(Employee::class, 'pm');
    }

    // Relasi ke client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    //relasi ke task
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }

    // Generate otomatis ID dan hitung ROI IDR
    protected static function booted(): void
    {
        static::creating(function ($project) {
            // Hitung ROI IDR jika data lengkap
            if ($project->nilai_kontrak !== null && $project->roi_percent !== null) {
                $project->roi_idr = ($project->nilai_kontrak * $project->roi_percent) / 100;
            }

            // Buat ID otomatis berdasarkan tipe
            $prefix = match ($project->type) {
                'Pendampingan' => 'PE',
                'Semi-Pendampingan' => 'SM',
                'Mentoring' => 'MT',
                'Perpetuation' => 'PP',
                default => 'XX',
            };

            $existingIds = static::where('id', 'like', $prefix . '%')->pluck('id')->toArray();
            $existingNumbers = collect($existingIds)
                ->map(fn ($id) => intval(substr($id, 2)))
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
