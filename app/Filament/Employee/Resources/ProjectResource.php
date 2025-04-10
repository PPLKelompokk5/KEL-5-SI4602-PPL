<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\ProjectResource\Pages;
use App\Filament\Employee\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\DatePicker::make('start')->required(),
                Forms\Components\DatePicker::make('end')->required(),
                Forms\Components\Select::make('client_id')
                    ->label('Client')
                    ->relationship('client', 'name')
                    ->searchable(),
                Forms\Components\Select::make('type')
                    ->label('Tipe Proyek')
                    ->options([
                        'Pendampingan' => 'Pendampingan',
                        'Semi-Pendampingan' => 'Semi-Pendampingan',
                        'Mentoring' => 'Mentoring',
                        'Perpetuation' => 'Perpetuation',
                    ])
                    ->required(),
                
                Forms\Components\TextInput::make('nilai_kontrak')->numeric(),
                Forms\Components\TextInput::make('roi_percent')->numeric(),
                Forms\Components\Select::make('status')
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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
