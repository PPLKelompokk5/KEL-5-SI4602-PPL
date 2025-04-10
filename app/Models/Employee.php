<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // penting!
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'position_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}