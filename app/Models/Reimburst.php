<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reimburst extends Model
{
    protected $fillable = [
        'id_karyawan',
        'nama_reimburse',
        'nama_pengaju',
        'project_id', // Changed from nama_project to project_id
        'nominal',
        'status_approval',
    ];

    /**
     * Get the project that owns the reimbursement.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    /**
     * Get the employee that owns the reimbursement.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'nama_pengaju', 'name');
    }
    public function karyawan()
{
    return $this->belongsTo(Karyawan::class, 'id_karyawan');
}

}
