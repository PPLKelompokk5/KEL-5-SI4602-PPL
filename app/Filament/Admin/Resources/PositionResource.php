<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Position;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\PositionResource\Pages;
use App\Filament\Admin\Resources\PositionResource\RelationManagers;


class PositionResource extends Resource
{
    protected static ?string $model = Position::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Posisi';
    protected static ?string $pluralLabel = 'Posisi';
    protected static ?string $navigationGroup = 'Master Employee';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Menambahkan input field untuk 'name'
                Forms\Components\TextInput::make('name')
                    ->label('Nama Posisi')
                    ->required()  // Menjadikan field ini wajib diisi
                    ->maxLength(255), // Mengatur panjang maksimal field

                Select::make('role_name')
                    ->label('Role')
                    ->options(Role::all()->pluck('name', 'name'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Pilih role yang sesuai dengan posisi ini'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Menambahkan kolom 'name' pada tabel
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Posisi')
                    ->sortable()
                    ->searchable(), // Menambahkan fitur pencarian di kolom ini

                Tables\Columns\TextColumn::make('role_name')
                    ->label('Role')
                    ->badge()
                    ->color('info')
                    ->sortable(),
            ])
            ->filters([
                // Menambahkan filter jika diperlukan
                Tables\Filters\SelectFilter::make('role_name')
                    ->label('Role')
                    ->options(Role::all()->pluck('name', 'name')),
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
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}
//commit
