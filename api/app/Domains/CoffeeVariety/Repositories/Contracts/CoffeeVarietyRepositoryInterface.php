<?php

namespace App\Domains\CoffeeVariety\Repositories\Contracts;

use App\Domains\CoffeeVariety\Models\CoffeeVariety;
use Illuminate\Database\Eloquent\Collection;

interface CoffeeVarietyRepositoryInterface
{
    /**
     * @return Collection<int, CoffeeVariety>
     */
    public function findActive(): Collection;

    public function findById(int $id): ?CoffeeVariety;
}
