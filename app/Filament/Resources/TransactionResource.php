<?php

namespace App\Filament\Resources;

use App\Enums\StatusType;
use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class TransactionResource extends Resource
{
    protected static ?string $navigationGroup = 'Transaction';

    protected static ?int $navigationSort = 2;

    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('payer_id')
                    ->relationship('payer', 'name')
                    ->required()
                    ->label('Payer Name'),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->label('Amount'),
                Forms\Components\DatePicker::make('due_date')->date(),
                Forms\Components\TextInput::make('vat')
                    ->numeric()
                    ->required()
                    ->label('Vat'),
                Checkbox::make('is_vat')->required()
                    ->label('Is Vat'),
                Select::make('status')
                    ->options(StatusType::toArray())
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payer.name'),
                TextColumn::make('amount')
                    ->money('IDR'),
                TextColumn::make('due_date')->dateTime('d F Y'),
                TextColumn::make('vat'),
                IconColumn::make('is_vat')
                    ->boolean(),
                TextColumn::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        'Paid' => 'heroicon-s-check-badge',
                        'Outstanding' => 'heroicon-o-exclamation-circle',
                        'Overdue' => 'heroicon-s-x-circle',
                        default => 'heroicon-s-x-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Paid' => 'success',
                        'Outstanding' => 'info',
                        'Overdue' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
