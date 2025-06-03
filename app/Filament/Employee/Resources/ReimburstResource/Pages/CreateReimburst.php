<?php

namespace App\Filament\Employee\Resources\ReimburstResource\Pages;

use App\Filament\Employee\Resources\ReimburstResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReimburst extends CreateRecord
{
    protected static string $resource = ReimburstResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
