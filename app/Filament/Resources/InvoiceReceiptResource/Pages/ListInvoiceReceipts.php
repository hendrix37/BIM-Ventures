<?php

namespace App\Filament\Resources\InvoiceReceiptResource\Pages;

use App\Filament\Resources\InvoiceReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvoiceReceipts extends ListRecords
{
    protected static string $resource = InvoiceReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
