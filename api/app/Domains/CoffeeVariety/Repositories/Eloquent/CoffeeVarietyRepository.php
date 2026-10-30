<?php

namespace App\Domains\CoffeeVariety\Repositories\Eloquent;

use App\Domains\CoffeeVariety\Models\CoffeeVariety;
use App\Domains\CoffeeVariety\Repositories\Contracts\CoffeeVarietyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CoffeeVarietyRepository implements CoffeeVarietyRepositoryInterface
{
    public function findActive(): Collection
    {
        return CoffeeVariety::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function findById(int $id): ?CoffeeVariety
    {
        return CoffeeVariety::find($id);
    }
}
