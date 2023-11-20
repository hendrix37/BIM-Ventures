<?php

namespace App\Http\Requests\InvoiceReceipt;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceReceiptRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'string'],
            'invoice_receipt_number' => ['required', 'string'],
            'payer_id' => ['nullable'],
            'payer_name' => ['nullable', 'string'],
            'amount' => ['nullable'],
            'invoice_id' => ['nullable'],
        ];
    }
}
