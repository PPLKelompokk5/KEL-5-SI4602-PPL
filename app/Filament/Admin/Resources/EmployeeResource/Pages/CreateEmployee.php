<?php

namespace App\Filament\Admin\Resources\EmployeeResource\Pages;

use App\Filament\Admin\Resources\EmployeeResource;
use App\Models\Position;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;



    protected function handleRecordCreation(array $data): Model
    {
        $position = Position::find($data['position_id']);
        if ($position) {
            $data['role_name'] = $position->role_name;
        } else {
            $data['role_name'] = null;
        }

        $employee = static::getModel()::create($data);

        if ($data['role_name']) {
            $employee->syncRoles([$data['role_name']]);
        }

        $user = \App\Models\User::updateOrCreate(
            ['email' => $employee->email],
            ['name' => $employee->name, 'password' => $employee->password]
        );
        $user->syncRoles([$data['role_name']]);
        return $employee;
    }


}
