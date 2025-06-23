<?php

namespace App\Filament\Employee\Resources;

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
use App\Filament\Employee\Resources\ReimburstResource\Pages;
use Filament\Forms\Components\Hidden; // Don't forget to import this!


class ReimburstResource extends Resource
{
    protected static ?string $model = Reimburst::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Reimbursements';

    protected static ?string $navigationGroup = 'Finance';

    protected static ?string $pluralModelLabel = 'Reimbursements';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nama_reimburse')
                            ->label('Reimbursement Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('nama_pengaju')
                            ->label('Requested By')
                            ->default(fn() => auth()->guard('web')->user()->name ?? '')
                            ->readOnly()
                            ->required(),

                        Select::make('project_id')
                            ->label('Project')
                            ->relationship(
                                name: 'project',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn (Builder $query) => $query->where('status', 1)
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('nominal')
                            ->label('Amount')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),

                        Select::make('status_approval')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->disabled()
                            ->dehydrated(),
                        Hidden::make('id_karyawan')
                            ->default(auth()->guard('web')->user()->id ?? null)
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_reimburse')
                    ->label('Reimbursement Name')
                    ->searchable(),
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable(),
                TextColumn::make('nominal')
                    ->label('Amount')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status_approval')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_approval')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            // ->modifyQueryUsing(fn (Builder $query) => $query->where('nama_pengaju', auth()->guard('employee')->user()->name ?? ''))
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (Reimburst $record): bool => $record->status_approval === 'pending'),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Reimburst $record): bool => $record->status_approval === 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListReimbursts::route('/'),
            'create' => Pages\CreateReimburst::route('/create'),
            'edit' => Pages\EditReimburst::route('/{record}/edit'),
        ];
    }

    public static function canEdit($record): bool
    {
        return $record->status_approval === 'pending';
    }

    public static function canDelete($record): bool
    {
        return $record->status_approval === 'pending';
    }
   public static function mutateFormDataBeforeCreate(array $data): array
{
    $data['id_karyawan'] = auth()->guard('employee')->user()->karyawan->id ?? null;
    return $data;
}

public static function mutateFormDataBeforeUpdate(array $data): array
{
    $data['id_karyawan'] = auth()->guard('employee')->user()->karyawan->id ?? null;
    return $data;
}


}
