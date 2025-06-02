<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Project';
    protected static ?string $navigationGroup = 'Master Project';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Baris 1
            Select::make('client_id')
                ->label('Client')
                ->relationship('client', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->columnSpanFull(),

            // Baris 2
            DatePicker::make('start')
                ->label('Tanggal Mulai')
                ->required(),

            DatePicker::make('end')
                ->label('Tanggal Selesai')
                ->required()
                ->rules([
                    fn (callable $get) => function (string $attribute, $value, \Closure $fail) use ($get) {
                        if ($value < $get('start')) {
                            $fail('Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
                        }
                    },
                ]),

            // Baris 3
            Select::make('type')
                ->label('Tipe Proyek')
                ->options([
                    'Pendampingan' => 'Pendampingan',
                    'Semi-Pendampingan' => 'Semi-Pendampingan',
                    'Mentoring' => 'Mentoring',
                    'Perpetuation' => 'Perpetuation',
                ])
                ->required()
                ->columnSpanFull(),

            // Baris 4
            Select::make('pm')
                ->label('Project Manager (PM)')
                ->relationship('pmEmployee', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Select::make('pd')
                ->label('Project Director (PD)')
                ->relationship('pdEmployee', 'name')
                ->searchable()
                ->preload()
                ->required(),

            // Baris 5
            TextInput::make('nilai_kontrak')
                ->label('Nilai Kontrak')
                ->numeric()
                ->required()
                ->reactive(),

            TextInput::make('roi_percent')
                ->label('ROI (%)')
                ->numeric()
                ->required()
                ->default(150)
                ->minValue(150)
                ->reactive(),

            // Baris 6
            TextInput::make('roi_idr')
                ->label('ROI (Rp)')
                ->disabled()
                ->dehydrated(false)
                ->formatStateUsing(function ($state, callable $get) {
                    $kontrak = $get('nilai_kontrak') ?? 0;
                    $persen = $get('roi_percent') ?? 0;
                    return 'Rp ' . number_format(($kontrak * $persen / 100), 0, ',', '.');
                }),

            // Baris 7
            Select::make('status')
                ->label('Status')
                ->options([
                    1 => 'Ongoing',
                    2 => 'Completed',
                    3 => 'Stopped',
                ])
                ->default(1)
                ->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('client.name')->label('Client'),
            TextColumn::make('pdEmployee.name')->label('PD'),
            TextColumn::make('pmEmployee.name')->label('PM'),
            TextColumn::make('start')->label('Mulai')->date(),
            TextColumn::make('end')->label('Selesai')->date(),
            TextColumn::make('type')->label('Tipe'),
            TextColumn::make('nilai_kontrak')
                ->label('Nilai Kontrak')
                ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            TextColumn::make('roi_percent')->label('ROI (%)')->formatStateUsing(fn ($state) => $state . '%'),
            SelectColumn::make('status')
                ->label('Status')
                ->options([
                    1 => 'Ongoing',
                    2 => 'Completed',
                    3 => 'Stopped',
                ])
                ->selectablePlaceholder(false)
                ->disablePlaceholderSelection()
                ->sortable(),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}