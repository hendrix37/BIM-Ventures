<?php

namespace App\Http\Resources\InvoiceReceipt;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceReceiptResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
			'invoice_receipt_number' => $this->invoice_receipt_number,
			'payer_id' => $this->payer_id,
			'payer_name' => $this->payer_name,
			'amount' => $this->amount,
			'invoice_id' => $this->invoice_id,
            'created_at' => dateTimeFormat($this->created_at),
            'updated_at' => dateTimeFormat($this->updated_at),
        ];
    }
}
