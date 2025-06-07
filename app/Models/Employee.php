<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Employee extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
        'position_id',
        'role_name',
        'status',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Determine which panels this user can access
     */
    public function canAccessPanel(Panel $panel): bool
    {

        // Super admin bisa akses semua panel
        if ($this->hasRole('super_admin')) {
            return true;
        }

        // Role lain hanya bisa akses employee panel
        if ($panel->getId() === 'employee') {
            return $this->hasAnyRole(['project_manager', 'project_director']);
        }

        // Tidak bisa akses admin panel kecuali super admin
        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($employee) {
            if ($employee->role_name) {
                $employee->syncRoles([$employee->role_name]);
            }
        });
    }




}
