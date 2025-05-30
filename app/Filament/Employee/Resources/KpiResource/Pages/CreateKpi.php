<?php

namespace App\Filament\Employee\Resources\KpiResource\Pages;

use App\Filament\Employee\Resources\KpiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKpi extends CreateRecord
{
    protected static string $resource = KpiResource::class;
    protected function getRedirectUrl(): string
    {
        return KpiResource::getUrl();
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['bulan'] = intval($data['tahun_input'] . str_pad($data['bulan_input'], 2, '0', STR_PAD_LEFT));
        unset($data['bulan_input'], $data['tahun_input']);
        return $data;
    }

}
