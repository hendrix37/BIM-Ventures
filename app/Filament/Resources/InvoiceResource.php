<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $navigationGroup = 'Transaction';

    protected static ?int $navigationSort = 2;

    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transaction_id')
                    ->relationship('transaction')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->payer->name} ({$record->amount})"),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Invoice Number'),
                TextColumn::make('payer.name')
                    ->label('Payer Name'),
                TextColumn::make('amount')
                    ->label('Amount'),
                ViewColumn::make('transaction_id')
                    ->view('tables.columns.transaction-link')
                    ->label('Transaction'),
                TextColumn::make('receipts_count')
                    ->counts('receipts')
                    ->default('0')
                    ->label('Count receipts'),
                TextColumn::make('receipts_sum_amount')
                    ->sum('receipts', 'amount')
                    ->default('0')
                    ->money('IDR')
                    ->label('Total Receipts'),
                TextColumn::make('created_at')
                    ->dateTime(' d F Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
