<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaskResource\Pages;
use App\Filament\Admin\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Card, Select, TextInput, TextArea, DatePicker};
use Filament\Tables\Columns\{TextColumn, BadgeColumn};

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                    Select::make('project_id')
                        ->label('Project')
                        ->relationship('project', 'id')
                        ->preload()
                        ->required()
                        ->searchable(),

                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    TextArea::make('description'),

                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'in_progress' => 'In Progress',
                            'completed' => 'Completed',
                        ])
                        ->default('pending')
                        ->required(),

                    DatePicker::make('due_date')
                            ->label('Due Date')
                            ->required(),

            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable(),
                BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'pending',
                        'warning' => 'in_progress',
                        'success' => 'completed',
                    ]),
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date('d M Y'),
            ])

            ->defaultSort('due_date', 'asc')
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
