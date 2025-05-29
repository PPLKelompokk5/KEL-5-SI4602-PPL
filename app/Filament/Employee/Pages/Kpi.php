<?php

namespace App\Filament\Employee\Pages;

use Filament\Pages\Page;

class Kpi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'KPI';

    protected static string $view = 'filament.employee.pages.kpi';

    public function getTitle(): string
    {
        return 'KPI';
    }
}