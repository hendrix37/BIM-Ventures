<?php

namespace App\Models;

use App\Enums\StatusType;
use App\Filters\TransactionFilters;
use App\Traits\Uuid;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory, Filterable, Uuid;

    protected string $default_filters = TransactionFilters::class;

    /**
     * Mass-assignable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'payer_id',
        'amount',
        'due_date',
        'vat',
        'is_vat',
        'status',
    ];

    protected $cast = [
        'uuid' => 'string',
        'payer_id' => 'integer',
        'amount' => 'integer',
        'due_date' => 'datetime',
        'vat' => 'double',
        'is_vat' => 'boolean',
    ];

    // Set the 'status' attribute as an enum
    protected $enums = [
        'status' => StatusType::class,
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id', 'id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'transaction_id', 'id');
    }
}
