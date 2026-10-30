<?php

namespace App\Domains\CoffeeVariety\Models;

use App\Domains\PriceOffer\Models\PriceOffer;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'is_active'])]
class CoffeeVariety extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function priceOffers(): HasMany
    {
        return $this->hasMany(PriceOffer::class);
    }
}
