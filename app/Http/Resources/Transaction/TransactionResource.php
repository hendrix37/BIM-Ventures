<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'payer_id' => $this->payer_id,
            'payer_name' => $this->payer,
            'amount' => $this->amount,
            'due_date' => dateTimeFormat($this->due_date),
            'vat' => $this->vat,
            'is_vat' => $this->is_vat,
            'status' => $this->status,
            'created_at' => dateTimeFormat($this->created_at),
            'updated_at' => dateTimeFormat($this->updated_at),
        ];
    }
}
