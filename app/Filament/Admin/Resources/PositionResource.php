<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PositionResource\Pages;
use App\Filament\Admin\Resources\PositionResource\RelationManagers;
use App\Models\Position;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
            ])
            ->filters([
                // Menambahkan filter jika diperlukan
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