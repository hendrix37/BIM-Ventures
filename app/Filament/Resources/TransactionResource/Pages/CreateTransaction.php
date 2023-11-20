<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\Invoice;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $count = Invoice::whereDate('created_at', Carbon::today())->count();

        do {
            $count++;
            $invoice_code = 'INV/' . date('Ymd') . '/' . $count;
        } while (Invoice::where('invoice_number', $invoice_code)->exists());

        Invoice::create([
            'invoice_number' => $invoice_code,
            'payer_id' => $this->record->payer_id,
            'amount' => $this->record->amount,
            'transaction_id' => $this->getRecord()->getKey(),
        ]);
    }
}
