<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Enums\StatusType;
use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $status = StatusType::toArray();
        $status_usage = null;
        foreach ($status as $key => $item) {

            if ($item == $data['status']) {
                $status_usage = $key;
            }
        }

        $data['status'] = $status_usage;

        return $data;
    }
}
