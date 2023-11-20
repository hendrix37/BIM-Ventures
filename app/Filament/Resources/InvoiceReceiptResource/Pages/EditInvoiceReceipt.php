<?php

namespace App\Filament\Resources\InvoiceReceiptResource\Pages;

use App\Filament\Resources\InvoiceReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvoiceReceipt extends EditRecord
{
    protected static string $resource = InvoiceReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
