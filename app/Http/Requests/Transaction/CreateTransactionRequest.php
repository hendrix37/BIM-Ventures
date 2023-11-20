<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'string'],
			'payer_id' => ['nullable'],
			'amount' => ['nullable'],
			'due_date' => ['nullable'],
			'vat' => ['nullable', 'numeric'],
			'is_vat' => ['required', 'boolean'],
			'status' => ['required', 'in:Paid,Outstanding,Overd'],
        ];
    }
}
