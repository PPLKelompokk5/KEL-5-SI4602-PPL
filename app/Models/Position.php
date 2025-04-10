<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = [
        'name',
    ];

    // Relasi: Satu posisi bisa punya banyak pegawai
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}