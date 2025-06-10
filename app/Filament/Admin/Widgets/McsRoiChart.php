<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\McsRoi;
use Illuminate\Support\Facades\DB;

class McsRoiChart extends ChartWidget
{
    protected static ?string $heading = 'Diagram Data MCS ROI per Proyek';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Ambil data ROI dari mcs_roi yang join ke projects
        $mcsRoiData = DB::table('mcs_roi')
            ->join('projects', 'mcs_roi.project_id', '=', 'projects.id')
            ->select(
                'projects.id as project_id',
                'projects.type as project_type',
                'projects.nilai_kontrak',
                'projects.roi_percent',
                'projects.roi_idr',
                'projects.status',
                'projects.start',
                'projects.end'
            )
            ->orderBy('projects.created_at', 'desc')
            ->get();

        // Jika data kosong, fallback ke tabel projects langsung
        if ($mcsRoiData->isEmpty()) {
            $projects = DB::table('projects')
                ->select(
                    'id as project_id',
                    'type as project_type',
                    'nilai_kontrak',
                    'roi_percent',
                    'roi_idr',
                    'status',
                    'start',
                    'end'
                )
                ->orderBy('created_at', 'desc')
                ->get();

            $labels = [];
            $data = [];
            foreach ($projects as $item) {
                $labels[] = $item->project_id . ' - ' . $item->project_type;
                $data[] = (float) ($item->roi_percent ?? 0);
            }

            return [
                'datasets' => [
                    [
                        'label' => 'ROI (%)',
                        'data' => $data,
                        'backgroundColor' => '#f59e0b',
                        'borderColor' => '#f59e0b',
                        'fill' => false,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        // Jika data ada, tampilkan dari join mcs_roi
        $labels = [];
        $data = [];
        foreach ($mcsRoiData as $item) {
            $labels[] = $item->project_id . ' - ' . $item->project_type;
            $data[] = (float) ($item->roi_percent ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'ROI (%)',
                    'data' => $data,
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#f59e0b',
                    'fill' => false,
                ],
            ],
            'labels' => $labels,
        ];
    }

    public function getTableData(): array
    {
        // Join ke tabel projects untuk tabel juga
        $rows = DB::table('mcs_roi')
            ->join('projects', 'mcs_roi.project_id', '=', 'projects.id')
            ->select(
                'projects.name as project_name',
                'mcs_roi.indicator',
                'mcs_roi.harga',
                'mcs_roi.target',
                'mcs_roi.uom',
                'mcs_roi.target_idr'
            )
            ->orderBy('mcs_roi.created_at', 'desc')
            ->get();

        return $rows->map(function ($item) {
            return [
                'project_name' => $item->project_name,
                'indicator' => $item->indicator,
                'harga' => $item->harga ? 'Rp ' . number_format($item->harga) : 'Rp 0',
                'target' => $item->target ?? '0',
                'uom' => $item->uom ?? '-',
                'target_idr' => $item->target_idr ? 'Rp ' . number_format($item->target_idr) : 'Rp 0',
            ];
        })->toArray();
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
