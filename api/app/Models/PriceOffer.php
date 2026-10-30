<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'buyer_id',
    'coffee_variety_id',
    'price_per_kg',
    'unit',
    'valid_from',
    'valid_until',
    'status',
    'notes',
])]
class PriceOffer extends Model
{
    protected function casts(): array
    {
        return [
            'price_per_kg' => 'decimal:2',
            'valid_from' => 'datetime',
            'valid_until' => 'datetime',
        ];
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }

    public function coffeeVariety(): BelongsTo
    {
        return $this->belongsTo(CoffeeVariety::class);
    }

    public function scopeApprovedAndValid(Builder $query): Builder
    {
        return $query->where('status', 'approved')->where('valid_until', '>', now());
    }
}
