<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProjectResource\Pages;
use App\Models\Client;
use App\Models\Employee;
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
use Filament\Tables\Columns\BooleanColumn;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Project';
    protected static ?string $navigationGroup = 'Master Project';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nama Proyek')
                ->required(),

            DatePicker::make('start')
                ->label('Tanggal Mulai')
                ->required(),

            DatePicker::make('end')
                ->label('Tanggal Selesai')
                ->required(),

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

            Select::make('client_id')
                ->label('Client')
                ->relationship('client', 'name')
                ->searchable()
                ->preload()
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

            TextInput::make('nilai_kontrak')
                ->label('Nilai Kontrak')
                ->numeric()
                ->required(),

            TextInput::make('roi_percent')
                ->label('ROI (%)')
                ->numeric()
                ->required(),

            TextInput::make('roi_idr')
                ->label('ROI (Rp)')
                ->disabled()
                ->dehydrated(false)
                ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

            Toggle::make('status')
                ->label('Status Aktif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Proyek')->searchable(),
                TextColumn::make('client.name')->label('Client'),
                TextColumn::make('pdEmployee.name')->label('PD'),
                TextColumn::make('pmEmployee.name')->label('PM'),
                TextColumn::make('start')->label('Mulai')->date(),
                TextColumn::make('end')->label('Selesai')->date(),
                TextColumn::make('type')->label('Tipe'),
                TextColumn::make('nilai_kontrak')->label('Nilai Kontrak')->money('IDR', locale: 'id'),
                TextColumn::make('roi_percent')->label('ROI (%)')->formatStateUsing(fn ($state) => $state . '%'),
                TextColumn::make('roi_idr')
                    ->label('ROI (Rp)')
                    ->formatStateUsing(function ($record) {
                        return 'Rp ' . number_format($record->roi_idr, 0, ',', '.');
                    }),
                BooleanColumn::make('status')->label('Status Aktif'),
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