<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;   // hapus jika tak dipakai
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

/**
 * @property int         $id
 * @property string      $name
 * @property string      $email
 * @property string|null $email_verified_at
 * @property string      $password
 * @property string|null $remember_token
 * @property \Carbon\CarbonInterface $created_at
 * @property \Carbon\CarbonInterface $updated_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /* -----------------------------------------------------------------
     |  Mass assignment
     |----------------------------------------------------------------- */
    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /* -----------------------------------------------------------------
     |  Hidden attributes (tidak ikut serialisasi JSON/array)
     |----------------------------------------------------------------- */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* -----------------------------------------------------------------
     |  Attribute casting
     |----------------------------------------------------------------- */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // Sejak Laravel 10, tipe 'hashed' akan otomatis Hash::make()
        'password' => 'hashed',
    ];

    /* -----------------------------------------------------------------
     |  Relationships (contoh)
     |----------------------------------------------------------------- */
    /*
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    */

    /* -----------------------------------------------------------------
     |  Accessors / Mutators tambahan (jika perlu)
     |----------------------------------------------------------------- */
     public function karyawan()
{
    return $this->hasOne(Karyawan::class, 'user_id');
}

    public function canAccessPanel(Panel $panel): bool
    {

        if ($panel->getId() === 'admin') {
            return $this->hasRole('super_admin');
        }

        if ($panel->getId() == 'employee') {
            return true;
        }

        return false;
    }
}
