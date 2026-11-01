<?php

namespace App\Domains\PriceOffer\Models;

use App\Domains\Buyer\Models\Buyer;
use App\Domains\CoffeeVariety\Models\CoffeeVariety;
use App\Enums\CoffeeState;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'buyer_id',
    'coffee_variety_id',
    'coffee_state',
    'price_per_kg',
    'moisture_required',
    'yield_factor',
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
            'coffee_state' => CoffeeState::class,
            'price_per_kg' => 'decimal:2',
            'moisture_required' => 'decimal:2',
            'yield_factor' => 'decimal:2',
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
