<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Reimburst;
use App\Models\Project;
use App\Models\Employee;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ReimburstResource\Pages;
use App\Filament\Admin\Resources\ReimburstResource\Pages\ListReimbursts; // Corrected use statement
use App\Filament\Admin\Resources\ReimburstResource\Pages\CreateReimburst; // Corrected use statement
use App\Filament\Admin\Resources\ReimburstResource\Pages\EditReimburst;   // Corrected use statement

// use App\Filament\Admin\Resources\ReimburstResource\RelationManagers;

class ReimburstResource extends Resource
{
    protected static ?string $model = Reimburst::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nama_reimburse')
                            ->required()
                            ->maxLength(255),
                        Select::make('nama_pengaju')
                            ->label('Nama Pengaju')
                            ->options(Employee::where('status', 'active')->pluck('name', 'name'))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('project_id')
                            ->label('Nama Project')
                            ->relationship('project', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('nominal')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Select::make('status_approval')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' =>  'Rejected',
                            ])
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_reimburse')
                    ->searchable(),
                TextColumn::make('nama_pengaju')
                    ->searchable(),
                TextColumn::make('project.name')
                    ->label('Nama Project')
                    ->searchable(),
                TextColumn::make('nominal')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status_approval')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => ListReimbursts::route('/'),
            'create' => CreateReimburst::route('/create'),
            'edit' => EditReimburst::route('/{record}/edit'),
        ];
    }
}
