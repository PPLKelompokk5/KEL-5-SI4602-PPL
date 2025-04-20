<?php

namespace App\Filament\Admin\Resources\ReimburstResource\Pages;

use App\Filament\Admin\Resources\ReimburstResource;
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
