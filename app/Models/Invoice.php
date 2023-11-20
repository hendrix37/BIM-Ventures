<?php

namespace App\Models;

use App\Filters\InvoiceFilters;
use App\Traits\Uuid;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory, Filterable, Uuid;

    protected string $default_filters = InvoiceFilters::class;

    /**
     * Mass-assignable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'invoice_number',
        'payer_id',
        'amount',
        'transaction_id',
    ];

    protected $cast = [
        'uuid' => 'string',
        'invoice_number' => 'string',
        'payer_id' => 'integer',
        'amount' => 'integer',
        'transaction_id' => 'integer',
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id', 'id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(InvoiceReceipt::class);
    }
}
