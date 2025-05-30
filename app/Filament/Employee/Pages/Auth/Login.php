<?php

namespace App\Filament\Employee\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected static string $view = 'filament.employee.auth.login'; // custom blade-mu
}