<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PresenceResource\Pages;
use App\Models\Presence;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PresenceResource extends Resource
{
    protected static ?string $model = Presence::class;
    protected static ?string $navigationGroup = 'Presensi';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Presensi';
    protected static ?int $navigationSort = 7; // Setelah Reimburst

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('employees_id')
                ->label('Karyawan')
                ->relationship('employee', 'name')
                ->searchable()
                ->required(),
            Forms\Components\Select::make('project_id')
                ->label('Project')
                ->relationship('project', 'name')
                ->searchable()
                ->required(),
            Forms\Components\Select::make('location_id')
                ->label('Lokasi')
                ->relationship('location', 'name')
                ->searchable()
                ->required(),
            Forms\Components\DatePicker::make('date')
                ->label('Tanggal')
                ->required(),
            Forms\Components\TextInput::make('timestamp')
                ->label('Waktu Presensi')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')->label('Karyawan'),
                Tables\Columns\TextColumn::make('project.name')->label('Project'),
                Tables\Columns\TextColumn::make('location.name')->label('Lokasi'),
                Tables\Columns\TextColumn::make('date')->label('Tanggal')->date('d-m-Y'),
                Tables\Columns\TextColumn::make('timestamp')->label('Waktu Presensi'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPresences::route('/'),
            'create' => Pages\CreatePresence::route('/create'),
            'edit' => Pages\EditPresence::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}
