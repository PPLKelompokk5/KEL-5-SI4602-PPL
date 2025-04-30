<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Projects';
    protected static ?string $navigationGroup = 'Presensi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('Nama Proyek')->required(),

            DatePicker::make('start')
                ->label('Tanggal Mulai')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    if ($state > $get('end')) {
                        $set('end', $state);
                    }
                }),

            DatePicker::make('end')
                ->label('Tanggal Selesai')
                ->required()
                ->rules([
                    fn (callable $get) => function ($attribute, $value, $fail) use ($get) {
                        if ($value < $get('start')) {
                            $fail('Tanggal selesai tidak boleh sebelum tanggal mulai.');
                        }
                    },
                ]),

            Select::make('client_id')
                ->label('Client')
                ->relationship('client', 'name')
                ->searchable()
                ->required(),

            Select::make('type')
                ->label('Tipe Proyek')
                ->options([
                    'Pendampingan' => 'Pendampingan',
                    'Semi-Pendampingan' => 'Semi-Pendampingan',
                    'Mentoring' => 'Mentoring',
                    'Perpetuation' => 'Perpetuation',
                ])
                ->required(),

            TextInput::make('nilai_kontrak')->label('Nilai Kontrak')->numeric()->required(),
            TextInput::make('roi_percent')->label('ROI (%)')->numeric()->required(),

            TextInput::make('roi_idr')
                ->label('ROI (Rp)')
                ->disabled()
                ->dehydrated(false)
                ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

            Select::make('status')
                ->label('Status')
                ->options([
                    1 => 'Ongoing',
                    2 => 'Completed',
                    3 => 'Stopped',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Proyek')->searchable(),
                TextColumn::make('client.name')->label('Client'),
                TextColumn::make('start')->label('Mulai')->date(),
                TextColumn::make('end')->label('Selesai')->date(),
                TextColumn::make('type')->label('Tipe'),
                TextColumn::make('nilai_kontrak')->label('Nilai Kontrak')->money('IDR', locale: 'id'),
                TextColumn::make('roi_percent')->label('ROI (%)')->formatStateUsing(fn ($state) => $state . '%'),
                TextColumn::make('roi_idr')->label('ROI (Rp)')
                    ->formatStateUsing(fn ($record) => 'Rp ' . number_format($record->roi_idr, 0, ',', '.')),

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
            ->actions([]) // tetap tanpa edit
            ->bulkActions([]); // tetap tanpa delete
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('pm', auth()->user()->id)
            ->orWhere('pd', auth()->user()->id);
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }
}