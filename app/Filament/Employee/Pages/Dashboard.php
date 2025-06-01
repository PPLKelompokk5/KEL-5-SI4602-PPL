<?php

namespace App\Filament\Employee\Pages;

use App\Models\Kpi;
use App\Models\KpiAktual;
use App\Models\Project;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static string $view = 'filament.employee.pages.dashboard';

    public $counts = [];

    public $selectedProject = null;
    public $selectedMonth = 'all';

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

    public function getProjectsProperty()
    {
        return Project::pluck('id', 'id');
    }

    public function getAvailableMonthsProperty()
    {
        return Kpi::distinct()->pluck('bulan')->mapWithKeys(function ($item) {
            return [$item => Carbon::createFromFormat('Ym', $item)->translatedFormat('F Y')];
        });
    }

    public function getFilteredKpisProperty()
    {
        return KpiAktual::when($this->selectedProject, fn ($q) =>
                $q->whereHas('kpi', fn ($sub) => $sub->where('project_id', $this->selectedProject)))
            ->when($this->selectedMonth !== 'all', fn ($q) =>
                $q->whereHas('kpi', fn ($sub) => $sub->where('bulan', $this->selectedMonth)))
            ->with('kpi')
            ->get();
    }

    public function getTotalScoreProperty()
    {
        return $this->filteredKpis->sum('skor');
    }

    public function getKpiByMonthProperty()
    {
        return $this->filteredKpis
            ->groupBy(function ($item) {
                return Carbon::createFromFormat('Ym', $item->kpi->bulan)->translatedFormat('F Y');
            });
    }
    
}