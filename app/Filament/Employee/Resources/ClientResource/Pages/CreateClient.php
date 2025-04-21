<?php

namespace App\Filament\Employee\Resources\ClientResource\Pages;

use App\Filament\Employee\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;
}
