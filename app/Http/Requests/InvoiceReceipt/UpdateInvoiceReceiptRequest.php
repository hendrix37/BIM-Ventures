<?php

namespace App\Http\Requests\InvoiceReceipt;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceReceiptRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['sometimes', 'string'],
            'invoice_receipt_number' => ['sometimes', 'string'],
            'payer_id' => ['sometimes'],
            'payer_name' => ['sometimes', 'string'],
            'amount' => ['sometimes'],
            'invoice_id' => ['sometimes'],
        ];
    }
}
