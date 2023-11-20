<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'string'],
            'invoice_number' => ['required', 'string'],
            'payer_id' => ['nullable'],
            'amount' => ['nullable'],
            'transaction' => ['nullable'],
        ];
    }
}
