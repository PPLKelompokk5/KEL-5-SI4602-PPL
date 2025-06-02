<?php

namespace App\Filament\Employee\Resources\ReimburstResource\Pages;

use App\Filament\Employee\Resources\ReimburstResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReimburst extends EditRecord
{
    protected static string $resource = ReimburstResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
