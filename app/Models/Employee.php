<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'position_id',
        'status',
    ];

    protected $hidden = ['password', 'remember_token'];
}