<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $count = Invoice::whereDate('created_at', Carbon::today())->count();
        
        $transaction = Transaction::find($data['transaction_id']);

        do {
            $count++;
            $invoice_code = 'INV/' . date('Ymd') . '/' . $count;
        } while (Invoice::where('invoice_number', $invoice_code)->exists());

        $data['invoice_number'] = $invoice_code;
        
        $data['amount'] = $transaction->amount;

        $data['payer_id'] = $transaction->payer_id;

        return $data;
    }
}
