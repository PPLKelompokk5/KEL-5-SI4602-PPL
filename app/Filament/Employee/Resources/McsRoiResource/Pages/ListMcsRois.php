<?php

namespace App\Filament\Employee\Resources\McsRoiResource\Pages;

use App\Filament\Employee\Resources\McsRoiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMcsRois extends ListRecords
{
    protected static string $resource = McsRoiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
