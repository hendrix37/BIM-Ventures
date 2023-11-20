<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceReceiptResource\Pages;
use App\Models\Invoice;
use App\Models\InvoiceReceipt;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InvoiceReceiptResource extends Resource
{
    protected static ?string $navigationGroup = 'Transaction';

    protected static ?int $navigationSort = 3;

    protected static ?string $model = InvoiceReceipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('invoice_id')
                    ->relationship(
                        name: 'invoice',
                        titleAttribute: 'invoice_number',
                        modifyQueryUsing: fn (Builder $query) => $query->whereHas('transaction', function ($query) {
                            $query->where('status', '!=', 'paid');
                        }),
                    ),

                Forms\Components\TextInput::make('payer_name'),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            $invoice = Invoice::find($get('invoice_id'));
                            $insufficient_payment = $invoice->amount - $invoice->receipts->sum('sum');

                            if ($value > $insufficient_payment) {
                                $fail('The amount exceeds the total due. just pay '.$insufficient_payment.' not more');
                            }

                            if ($invoice->amount <= $invoice->receipts->sum('amount')) {
                                $fail('The invoice has been paid in full');
                            }
                        },
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_receipt_number')
                    ->label('Receipt Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payer.name')
                    ->label('Payer Name Transaction')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice.invoice_number')
                    ->label('Invoice Number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payer_name')
                    ->label('Payer Payment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
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
            'index' => Pages\ListInvoiceReceipts::route('/'),
            'create' => Pages\CreateInvoiceReceipt::route('/create'),
            'edit' => Pages\EditInvoiceReceipt::route('/{record}/edit'),
        ];
    }
}
