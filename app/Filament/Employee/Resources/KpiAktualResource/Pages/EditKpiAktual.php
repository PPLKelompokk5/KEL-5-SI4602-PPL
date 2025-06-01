<?php

namespace App\Filament\Employee\Resources\KpiAktualResource\Pages;

use App\Filament\Employee\Resources\KpiAktualResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKpiAktual extends EditRecord
{
    protected static string $resource = KpiAktualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
