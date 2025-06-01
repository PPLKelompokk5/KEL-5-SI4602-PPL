<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\KpiAktualResource\Pages;
use App\Models\KpiAktual;
use App\Models\Kpi;
use App\Models\Presence;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Reimburst;

class KpiAktualResource extends Resource
{
    protected static ?string $model = KpiAktual::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'KPI';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('kpi_id')
                ->label('Pilih KPI')
                ->options(function () {
                    $usedIds = KpiAktual::pluck('kpi_id')->toArray();
                    return Kpi::whereNotIn('id', $usedIds)
                        ->get()
                        ->mapWithKeys(function ($kpi) {
                            $bulan = Carbon::createFromFormat('Ym', $kpi->bulan)->translatedFormat('F Y');
                            return [$kpi->id => "{$kpi->project_id} - {$kpi->indikator} - {$bulan}"];
                        });
                })
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $kpi = Kpi::find($state);

                    if (!$kpi) {
                        $set('nilai', null);
                        $set('target', null);
                        $set('level', null);
                        $set('skor', null);
                        return;
                    }

                    $tanggal = Carbon::createFromFormat('Ym', $kpi->bulan);
                    $nilai = 0;

                    if ($kpi->indikator === 'Mandays') {
                        $nilai = Presence::where('project_id', $kpi->project_id)
                            ->whereMonth('date', $tanggal->month)
                            ->whereYear('date', $tanggal->year)
                            ->count();
                    } else {
                        $nilai = Reimburst::where('project_id', $kpi->project_id)
                            ->where('status_approval', 'approved')
                            ->whereMonth('created_at', $tanggal->month)
                            ->whereYear('created_at', $tanggal->year)
                            ->sum('nominal');
                    }

                    $closestLevel = 1;
                    $minDiff = null;

                    foreach (range(1, 10) as $i) {
                        $kolom = 'level_' . $i;
                        $diff = abs($nilai - $kpi->$kolom);
                        if (is_null($minDiff) || $diff < $minDiff) {
                            $closestLevel = $i;
                            $minDiff = $diff;
                        }
                    }

                    $set('nilai', $nilai);
                    $set('target', $kpi->target);
                    $set('level', $closestLevel);
                    $set('skor', $closestLevel * 25);
                })
                ->required(),

            Forms\Components\TextInput::make('nilai')
                ->numeric()
                ->readOnly(),

            Forms\Components\TextInput::make('target')
                ->numeric()
                ->readOnly(),

            Forms\Components\TextInput::make('level')
                ->numeric()
                ->readOnly(),

            Forms\Components\TextInput::make('skor')
                ->numeric()
                ->readOnly(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kpi_id')
                    ->label('KPI')
                    ->formatStateUsing(function ($state) {
                        $kpi = \App\Models\Kpi::with('project.client')->find($state);
                        if (!$kpi || !$kpi->project || !$kpi->project->client) return '-';
                        $bulan = \Carbon\Carbon::createFromFormat('Ym', $kpi->bulan)->translatedFormat('F Y');
                        return "{$kpi->project->client->name} - {$kpi->project_id} - {$kpi->indikator} - {$bulan}";
                    }),

                Tables\Columns\TextColumn::make('nilai')->numeric(),
                Tables\Columns\TextColumn::make('target')->numeric(),
                Tables\Columns\TextColumn::make('level')->numeric(),
                Tables\Columns\TextColumn::make('skor')->numeric(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions(actions: [
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKpiAktuals::route('/'),
            'create' => Pages\CreateKpiAktual::route('/create'),
            'edit' => Pages\EditKpiAktual::route('/{record}/edit'),
        ];
    }
}