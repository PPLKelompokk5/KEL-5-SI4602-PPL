<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reimburst extends Model
{
    protected $fillable = [
        'nama_reimburse',
        'nama_pengaju',
        'nama_project',
        'nominal',
        'status_approval',
    ];
}
