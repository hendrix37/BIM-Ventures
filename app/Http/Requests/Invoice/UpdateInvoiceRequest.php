<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['sometimes', 'string'],
            'invoice_number' => ['sometimes', 'string'],
            'payer_id' => ['sometimes'],
            'amount' => ['sometimes'],
            'transaction' => ['sometimes'],
        ];
    }
}
