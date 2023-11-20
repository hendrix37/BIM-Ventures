<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['sometimes', 'string'],
            'payer_id' => ['sometimes'],
            'amount' => ['sometimes'],
            'due_date' => ['sometimes'],
            'vat' => ['sometimes', 'numeric'],
            'is_vat' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'in:Paid,Outstanding,Overd'],
        ];
    }
}
