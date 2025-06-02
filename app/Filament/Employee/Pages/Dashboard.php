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
    public $selectedYear = null;

    public function mount(): void
    {
        $employeeId = Auth::guard('employee')->id();

        $this->counts = [
            'Pendampingan' => Project::where('type', 'Pendampingan')
                ->where(fn($q) => $q->where('pd', $employeeId)->orWhere('pm', $employeeId))
                ->count(),
            'Semi-Pendampingan' => Project::where('type', 'Semi-Pendampingan')
                ->where(fn($q) => $q->where('pd', $employeeId)->orWhere('pm', $employeeId))
                ->count(),
            'Mentoring' => Project::where('type', 'Mentoring')
                ->where(fn($q) => $q->where('pd', $employeeId)->orWhere('pm', $employeeId))
                ->count(),
            'Perpetuation' => Project::where('type', 'Perpetuation')
                ->where(fn($q) => $q->where('pd', $employeeId)->orWhere('pm', $employeeId))
                ->count(),
        ];
    }

    public function getProjectsProperty()
    {
        return Project::where(fn($q) => $q->where('pd', Auth::guard('employee')->id())->orWhere('pm', Auth::guard('employee')->id()))
            ->pluck('id', 'id');
    }

    public function getAvailableYearsProperty()
    {
        return Kpi::distinct()
            ->pluck('bulan')
            ->map(fn($bulan) => substr($bulan, 0, 4))
            ->unique()
            ->values();
    }

    public function getFilteredMonthsProperty()
    {
        return Kpi::distinct()
            ->when($this->selectedYear, fn($q) => $q->where('bulan', 'like', $this->selectedYear . '%'))
            ->pluck('bulan')
            ->mapWithKeys(function ($item) {
                try {
                    $carbon = Carbon::createFromFormat('Ym', strval($item));
                    return [$carbon->format('m') => $carbon->translatedFormat('F')];
                } catch (\Exception $e) {
                    return [$item => $item];
                }
            });
    }

    public function getFilteredKpisProperty()
    {
        return KpiAktual::select('id', 'kpi_id', 'nilai', 'target', 'level', 'skor')
            ->when($this->selectedProject, fn($q) =>
                $q->whereHas('kpi', fn($sub) => $sub->where('project_id', $this->selectedProject)))
            ->when($this->selectedMonth !== 'all', fn($q) =>
                $q->whereHas('kpi', fn($sub) => $sub->where('bulan', intval($this->selectedMonth))))
            ->when($this->selectedYear, fn($q) =>
                $q->whereHas('kpi', fn($sub) => $sub->where('bulan', 'like', $this->selectedYear . '%')))
            ->with(['kpi' => fn($q) => $q->select('id', 'project_id', 'bulan', 'indikator', 'uom', 'target')
                ->with(['project' => fn($q) => $q->select('id')])])
            ->get();
    }

    public function getKpiChartDataProperty()
    {
        return $this->filteredKpis
            ->groupBy(fn($item) => $item->kpi->bulan)
            ->map(function ($items, $bulan) {
                return [
                    'bulan' => Carbon::createFromFormat('Ym', $bulan)->translatedFormat('F Y'),
                    'Mandays' => $items->filter(fn($i) => $i->kpi->indikator === 'Mandays')->sum('skor'),
                    'Budget' => $items->filter(fn($i) => $i->kpi->indikator === 'Budget')->sum('skor'),
                    'ROI'    => $items->filter(fn($i) => $i->kpi->indikator === 'ROI')->sum('skor'),
                ];
            })
            ->values();
    }

    public function getTotalScoreProperty()
    {
        return $this->filteredKpis->sum('skor');
    }

    public function resetFilters()
    {
        $this->selectedProject = null;
        $this->selectedYear = null;
        $this->selectedMonth = 'all';
    }

    public function updatedSelectedProject()
    {
        $this->dispatch('updateKpiChart', data: $this->kpiChartData);
    }
}