<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Reimburst;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ReimburstResource\Pages;
use App\Filament\Admin\Resources\ReimburstResource\RelationManagers;

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
                        TextInput::make('nama_reimburse'),
                        TextInput::make('nama_pengaju'),
                        TextInput::make('nama_project'),
                        TextInput::make('nominal'),
                        Select::make('status_approval')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' =>  'Rejected',
                            ]),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_reimburse'),
                TextColumn::make('nama_pengaju'),
                TextColumn::make('nama_project'),
                TextColumn::make('nominal'),
                TextColumn::make('status_approval'),
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

    // lupa banget ga pake kode jira nya yaallahhhh

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReimbursts::route('/'),
            'create' => Pages\CreateReimburst::route('/create'),
            'edit' => Pages\EditReimburst::route('/{record}/edit'),
        ];
    }
}
