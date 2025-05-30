<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\KpiResource\Pages;
use App\Models\Kpi;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\Checkbox;

class KpiResource extends Resource
{
    protected static ?string $model = Kpi::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'KPI';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->options(function () {
                        return Project::with('client')
                            ->get()
                            ->mapWithKeys(function ($project) {
                                return [
                                    $project->id => $project->id . ' - ' . ($project->client->name ?? '-'),
                                ];
                            });
                    })
                    ->required()
                    ->columnSpanFull(),
                    
                Forms\Components\Grid::make(2)
                    ->schema([
                        Select::make('indikator')
                            ->label('Indikator')
                            ->options([
                                'Mandays' => 'Mandays',
                                'Budget' => 'Budget',
                                'ROI' => 'ROI',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                $uoms = [
                                    'Mandays' => 'Hari',
                                    'Budget' => 'Rp',
                                    'ROI' => '%',
                                ];

                                if (isset($uoms[$state])) {
                                    $set('uom', $uoms[$state]);
                                }
                            }),

                        TextInput::make('uom')
                            ->required()
                            ->label('UOM'),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Select::make('bulan_input')
                            ->label('Bulan')
                            ->options([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) =>
                                $set('bulan', intval($get('tahun_input') . str_pad($state, 2, '0', STR_PAD_LEFT)))
                            ),

                        Select::make('tahun_input')
                            ->label('Tahun')
                            ->options(collect(range(date('Y') - 5, date('Y') + 5))->mapWithKeys(fn ($y) => [$y => $y]))
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) =>
                                $set('bulan', intval($state . str_pad($get('bulan_input'), 2, '0', STR_PAD_LEFT)))
                            ),
                    ]),

                Forms\Components\Hidden::make('bulan'),

                Forms\Components\Grid::make(2)
                    ->schema([
                        TextInput::make('base')
                            ->numeric()
                            ->required()
                            ->live(debounce: 300)
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $base = floatval($state);
                                $target = floatval($get('target'));

                                if (!is_numeric($target) || !is_numeric($base) || $base === $target) {
                                    foreach (range(1, 10) as $i) {
                                        $set("level_$i", null);
                                    }
                                    return;
                                }

                                self::hitungLevel($base, $target, $set);
                            }),

                        TextInput::make('target')
                            ->numeric()
                            ->required()
                            ->live(debounce: 300)
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $target = floatval($state);
                                $base = floatval($get('base'));

                                if (!is_numeric($target) || !is_numeric($base) || $base === $target) {
                                    foreach (range(1, 10) as $i) {
                                        $set("level_$i", null);
                                    }
                                    return;
                                }

                                self::hitungLevel($base, $target, $set);
                            }),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema(
                        collect(range(1, 10))->map(fn ($i) =>
                            TextInput::make("level_$i")
                                ->label("Level $i")
                                ->numeric()
                                ->readOnly()
                        )->toArray()
                    ),
            ]);
    }

    protected static function hitungLevel($base, $target, Set $set): void
    {
        $base = floatval($base);
        $target = floatval($target);

        if ($base <= 0 || $target <= 0 || $base === $target) {
            foreach (range(1, 10) as $i) {
                $set("level_$i", null);
            }
            return;
        }

        $selisih = abs($target - $base) / 4;

        if ($target > $base) {
            // Kenaikan normal
            $set('level_4', $base);
            $set('level_3', $base - $selisih);
            $set('level_2', $base - 2 * $selisih);
            $set('level_1', $base - 3 * $selisih);
            $set('level_5', $base + $selisih);
            $set('level_6', $base + 2 * $selisih);
            $set('level_7', $base + 3 * $selisih);
            $set('level_8', $target);
            $set('level_9', $target + $selisih);
            $set('level_10', $target + 2 * $selisih);
        } else {
            // Penurunan
            $set('level_4', $base);
            $set('level_3', $base + $selisih);
            $set('level_2', $base + 2 * $selisih);
            $set('level_1', $base + 3 * $selisih);
            $set('level_5', $base - $selisih);
            $set('level_6', $base - 2 * $selisih);
            $set('level_7', $base - 3 * $selisih);
            $set('level_8', $target);
            $set('level_9', $target - $selisih);
            $set('level_10', $target - 2 * $selisih);
        }
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.id')
                    ->label('Project')
                    ->formatStateUsing(fn ($state, $record) =>
                        $state . ' - ' . ($record->project->client->name ?? '-')
                    )
                    ->sortable(),

                TextColumn::make('indikator')
                    ->label('Indikator')
                    ->searchable(),

                TextColumn::make('uom')
                    ->label('UOM'),

                TextColumn::make('bulan')
                    ->label('Bulan')
                    ->formatStateUsing(fn ($state) =>
                        \Carbon\Carbon::createFromFormat('Ym', $state)->translatedFormat('F Y')
                    ),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListKpis::route('/'),
            'create' => Pages\CreateKpi::route('/create'),
            'edit' => Pages\EditKpi::route('/{record}/edit'),
        ];
    }
}