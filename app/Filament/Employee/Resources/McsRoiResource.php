<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\McsRoiResource\Pages;
use App\Models\McsRoi;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class McsRoiResource extends Resource
{
    protected static ?string $model = McsRoi::class;
    protected static ?string $navigationGroup = 'MCS';
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'MCS ROI';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('project_id')
                ->label('Project')
                ->relationship(
                    name: 'project',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->where(function ($q) {
                        $userId = auth()->id();
                        $q->where('pm', $userId)->orWhere('pd', $userId);
                    })
                )
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('indicator')
                ->label('Indicator')
                ->required(),

            Forms\Components\TextInput::make('harga')
                ->label('Harga')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                    $set('target_idr', (float) $state * (float) $get('target'))
                ),

            Forms\Components\TextInput::make('target')
                ->label('Target')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                    $set('target_idr', (float) $state * (float) $get('harga'))
                ),

            Forms\Components\TextInput::make('uom')
                ->label('UOM')
                ->required(),

            Forms\Components\TextInput::make('target_idr')
                ->label('Target IDR')
                ->disabled()
                ->dehydrated()
                ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')->label('Project'),
                Tables\Columns\TextColumn::make('indicator')->label('Indicator'),
                Tables\Columns\TextColumn::make('harga')->label('Harga')->money('IDR', locale: 'id'),
                Tables\Columns\TextColumn::make('target')->label('Target'),
                Tables\Columns\TextColumn::make('uom')->label('UOM'),
                Tables\Columns\TextColumn::make('target_idr')->label('Target IDR')->money('IDR', locale: 'id'),
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
            'index' => Pages\ListMcsRois::route('/'),
            'create' => Pages\CreateMcsRoi::route('/create'),
            'edit' => Pages\EditMcsRoi::route('/{record}/edit'),
        ];
    }

    // Opsional: hanya tampilkan data project milik user login
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('project', function ($query) {
            $query->where('pm', auth()->id())->orWhere('pd', auth()->id());
        });
    }
}