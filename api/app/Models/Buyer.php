<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'type', 'description', 'latitude', 'longitude', 'address', 'phone', 'is_active'])]
class Buyer extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function priceOffers(): HasMany
    {
        return $this->hasMany(PriceOffer::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
