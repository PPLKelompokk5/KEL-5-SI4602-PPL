<?php

namespace App\Filament\Admin\Resources;

use App\Models\Kpi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Admin\Resources\KpiResource\Pages;

class KpiResource extends Resource
{
    protected static ?string $model = Kpi::class;
    protected static ?string $navigationGroup = 'KPI';
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';
    protected static ?string $navigationLabel = 'KPI Project';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('project_id')
                ->label('Project')
                ->relationship('project', 'name')
                ->required(),
            Forms\Components\TextInput::make('roi')
                ->label('ROI')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('mandays')
                ->label('Mandays')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('budget')
                ->label('Budget')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')->label('Project'),
                Tables\Columns\TextColumn::make('roi')->label('ROI'),
                Tables\Columns\TextColumn::make('mandays')->label('Mandays'),
                Tables\Columns\TextColumn::make('budget')->label('Budget')->money('IDR', locale: 'id'),
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
            'index' => Pages\ListKpis::route('/'),
            'create' => Pages\CreateKpi::route('/create'),
            'edit' => Pages\EditKpi::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}
