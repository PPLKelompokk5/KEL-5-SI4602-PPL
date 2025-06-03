<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiAktual extends Model
{
    protected $fillable = ['kpi_id', 'nilai', 'target', 'level', 'skor'];

    public function kpi()
    {
        return $this->belongsTo(Kpi::class, 'kpi_id');
    }
}