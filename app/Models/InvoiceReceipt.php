<?php

namespace App\Models;

use App\Filters\InvoiceReceiptFilters;
use App\Traits\Uuid;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceReceipt extends Model
{
    use Filterable, HasFactory, Uuid;

    protected string $default_filters = InvoiceReceiptFilters::class;

    /**
     * Mass-assignable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'invoice_receipt_number',
        'payer_id',
        'payer_name',
        'amount',
        'invoice_id',
    ];

    protected $cast = [
        'uuid' => 'string',
        'invoice_receipt_number' => 'string',
        'payer_id' => 'integer',
        'payer_name' => 'string',
        'amount' => 'integer',
        'invoice_id' => 'integer',
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id', 'id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
