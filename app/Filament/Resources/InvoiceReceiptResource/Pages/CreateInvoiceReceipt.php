<?php

namespace App\Filament\Resources\InvoiceReceiptResource\Pages;

use App\Enums\StatusType;
use App\Filament\Resources\InvoiceReceiptResource;
use App\Models\Invoice;
use App\Models\InvoiceReceipt;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoiceReceipt extends CreateRecord
{
    protected static string $resource = InvoiceReceiptResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $count = InvoiceReceipt::whereDate('created_at', Carbon::today())->count();

        $invoice = Invoice::find($data['invoice_id']);

        do {
            $count++;
            $invoice_code = 'INV/'.date('Ymd').'/'.$count;
        } while (InvoiceReceipt::where('invoice_receipt_number', $invoice_code)->exists());

        $data['invoice_receipt_number'] = $invoice_code;

        $data['payer_id'] = $invoice->payer_id;

        return $data;
    }

    protected function afterCreate(): void
    {
        $invoice = Invoice::find($this->getRecord()->invoice_id);
        $receipt_sum_amount = $invoice->receipts->sum('amount');

        if ($invoice->amount <= $receipt_sum_amount) {
            $transaction = Transaction::find($invoice->transaction_id);
            $transaction->status = StatusType::PAID;
            $transaction->update();
        }
    }
}
