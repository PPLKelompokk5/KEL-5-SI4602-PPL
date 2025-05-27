<?php

namespace App\Filament\Admin\Resources\LocationResource\Pages;

use App\Filament\Admin\Resources\LocationResource;
use App\Models\Project;
use Filament\Resources\Pages\CreateRecord;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $project = Project::find($data['project_id']);
        $data['status'] = ($project && $project->status == 1) ? ($data['status'] ?? 0) : 0;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return LocationResource::getUrl('index'); // ⬅ redirect ke halaman index
    }
}