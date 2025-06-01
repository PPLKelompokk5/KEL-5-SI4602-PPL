<?php

namespace App\Filament\Employee\Pages;

use App\Models\Project;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static string $view = 'filament.employee.pages.dashboard';

    public $counts = [];

    public function mount(): void
    {
        $employeeId = Auth::guard('employee')->id();

        $this->counts = [
            'Pendampingan' => Project::where('type', 'Pendampingan')
                ->where(fn ($q) => $q->where('pd', $employeeId)->orWhere('pm', $employeeId))
                ->count(),

            'Semi-Pendampingan' => Project::where('type', 'Semi-Pendampingan')
                ->where(fn ($q) => $q->where('pd', $employeeId)->orWhere('pm', $employeeId))
                ->count(),

            'Mentoring' => Project::where('type', 'Mentoring')
                ->where(fn ($q) => $q->where('pd', $employeeId)->orWhere('pm', $employeeId))
                ->count(),

            'Perpetuation' => Project::where('type', 'Perpetuation')
                ->where(fn ($q) => $q->where('pd', $employeeId)->orWhere('pm', $employeeId))
                ->count(),
        ];
    }
}