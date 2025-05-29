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
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'MCS';
    protected static ?string $navigationLabel = 'Kpis';

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
                            ->options(fn (Get $get) =>
                                Kpi::where('project_id', $get('project_id'))
                                    ->pluck('indikator', 'indikator')
                            )
                            ->required()
                            ->visible(fn (Get $get) => !$get('tambah_indikator_baru'))
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $uom = Kpi::where('project_id', $get('project_id'))
                                    ->where('indikator', $state)
                                    ->value('uom');

                                if ($uom) {
                                    $set('uom', $uom);
                                }
                            }),

                        TextInput::make('indikator')
                            ->label('Indikator Baru')
                            ->required()
                            ->visible(fn (Get $get) => $get('tambah_indikator_baru')),

                        TextInput::make('uom')
                            ->required()
                            ->label('UOM'),
                    ]),

                Checkbox::make('tambah_indikator_baru')
                    ->label('Tambah indikator baru')
                    ->reactive(),

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
                            ->rules(fn (Get $get) => [
                                function ($attribute, $value, $fail) use ($get) {
                                    $target = $get('target');
                                    if (is_numeric($target) && $value >= $target) {
                                        $fail('The base must be less than the target.');
                                    }
                                },
                            ])
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $base = floatval($state);
                                $target = floatval($get('target'));

                                if (!is_numeric($target) || $base >= $target) {
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
                            ->rules(fn (Get $get) => [
                                function ($attribute, $value, $fail) use ($get) {
                                    $base = $get('base');
                                    if (is_numeric($base) && $value <= $base) {
                                        $fail('The target must be greater than the base.');
                                    }
                                },
                            ])
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $target = floatval($state);
                                $base = floatval($get('base'));

                                if (!is_numeric($base) || $base >= $target) {
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
                                ->disabled()
                        )->toArray()
                    ),
            ]);
    }

    protected static function hitungLevel($base, $target, Set $set): void
    {
        $base = floatval($base);
        $target = floatval($target);

        if ($base > 0 && $target > $base) {
            $selisih = ($target - $base) / 4;

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
            foreach (range(1, 10) as $i) {
                $set("level_$i", null);
            }
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