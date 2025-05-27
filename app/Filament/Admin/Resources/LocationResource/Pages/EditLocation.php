<?php

namespace App\Filament\Admin\Resources\LocationResource\Pages;

use App\Filament\Admin\Resources\LocationResource;
use App\Models\Project;
use Filament\Resources\Pages\EditRecord;

class EditLocation extends EditRecord
{
    protected static string $resource = LocationResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $project = Project::find($data['project_id']);
        $data['status'] = ($project && $project->status == 1) ? ($data['status'] ?? 0) : 0;

        return $data;
    }
}