<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'role_name'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }


    public function getRoleNameAttribute()
    {
        return $this->attributes['role_name'];
    }

}
//comit
