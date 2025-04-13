<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'start', 'end', 'pd', 'pm', 'type',
        'nilai_kontrak', 'roi_percent', 'client_id', 'status',
    ];

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
}