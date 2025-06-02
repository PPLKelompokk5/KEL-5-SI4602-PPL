<?php

namespace App\Filament\Employee\Resources\KpiAktualResource\Pages;

use App\Filament\Employee\Resources\KpiAktualResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKpiAktual extends CreateRecord
{
    protected static string $resource = KpiAktualResource::class;

    protected function getCreateFormActionLabel(): string
    {
        return 'Rekap';
    }
}