<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Validation\Rule;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Lokasi';
    protected static ?string $pluralLabel = 'Lokasi';
    protected static ?string $navigationGroup = 'Master Project';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_id')
                    ->label('Project')
                    ->relationship(
                        name: 'project',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn (Builder $query) => $query->where('status', 1)
                    )
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn ($record) =>
                        $record->id . ' - ' . ($record->client->name ?? '-')
                    )
                    ->live()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $project = \App\Models\Project::with('client')->find($state);
                        $set('client_id', $project?->client?->id);
                        if ($project && $project->status != 1) {
                            $set('status', false);
                        }
                    })
                    ->required(),

                TextInput::make('name')
                    ->label('Nama Lokasi')
                    ->required()
                    ->maxLength(255)
                    ->rules([
                        fn (callable $get) => Rule::unique('locations', 'name')
                            ->where('project_id', $get('project_id')),
                    ]),

                Toggle::make('status')
                    ->label('Status Aktif')
                    ->default(true)
                    ->disabled(fn (callable $get) =>
                        optional(\App\Models\Project::find($get('project_id')))->status != 1
                    )
                    ->dehydrated(true),
            ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.id')->label('Project'),
                TextColumn::make('client.name')->label('Client'),
                TextColumn::make('name')->label('Nama Lokasi'),
                ToggleColumn::make('status')
                    ->label('Status')
                    ->disabled(fn ($record) =>
                        optional($record->project)->status != 1
                    ),
            ])
            ->filters([]) // pastikan ini di luar columns
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}