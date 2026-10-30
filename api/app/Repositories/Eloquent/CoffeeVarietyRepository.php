<?php

namespace App\Repositories\Eloquent;

use App\Models\CoffeeVariety;
use App\Repositories\Contracts\CoffeeVarietyRepositoryInterface;
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
