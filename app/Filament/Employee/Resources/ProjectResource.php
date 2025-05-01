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
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
            Forms\Components\Grid::make(2)
                ->schema([
                    Select::make('client_id')
                        ->label('Client')
                        ->relationship('client', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
    
                    TextInput::make('name')
                        ->label('Nama Proyek')
                        ->required(),
                ]),
    
            Forms\Components\Grid::make(2)
                ->schema([
                    DatePicker::make('start')
                        ->label('Tanggal Mulai')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            if ($get('end') && $state > $get('end')) {
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
                ]),
    
            Forms\Components\Grid::make(2)
                ->schema([
                    Select::make('pd')
                        ->label('Project Director (PD)')
                        ->relationship('pdEmployee', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
    
                    Select::make('pm')
                        ->label('Project Manager (PM)')
                        ->relationship('pmEmployee', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),
    
            Forms\Components\Grid::make(2)
                ->schema([
                    Select::make('type')
                        ->label('Tipe Proyek')
                        ->options([
                            'Pendampingan' => 'Pendampingan',
                            'Semi-Pendampingan' => 'Semi-Pendampingan',
                            'Mentoring' => 'Mentoring',
                            'Perpetuation' => 'Perpetuation',
                        ])
                        ->required(),
    
                    TextInput::make('nilai_kontrak')
                        ->label('Nilai Kontrak')
                        ->numeric()
                        ->required(),
                ]),
    
            Forms\Components\Grid::make(2)
                ->schema([
                    TextInput::make('roi_percent')
                        ->label('ROI (%)')
                        ->numeric()
                        ->required(),
    
                    TextInput::make('roi_idr')
                        ->label('ROI (Rp)')
                        ->disabled()
                        ->dehydrated(false)
                        ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                ]),
    
            // Tidak perlu tampilkan status di form, tapi pastikan default = 1 di model/controller jika pakai mass assignment
        ]);
    }    
    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nama Proyek')->searchable(),
            TextColumn::make('client.name')->label('Client'),
            TextColumn::make('pdEmployee.name')->label('PD'),
            TextColumn::make('pmEmployee.name')->label('PM'),
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
        ->actions([])
        ->bulkActions([]);
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