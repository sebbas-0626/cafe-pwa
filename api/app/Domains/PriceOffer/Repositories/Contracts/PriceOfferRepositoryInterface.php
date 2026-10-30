<?php

namespace App\Domains\PriceOffer\Repositories\Contracts;

use App\Domains\PriceOffer\Models\PriceOffer;
use Illuminate\Database\Eloquent\Collection;

interface PriceOfferRepositoryInterface
{
    /**
     * @return Collection<int, PriceOffer>
     */
    public function findApprovedByVariety(int $varietyId): Collection;

    /**
     * @return Collection<int, PriceOffer>
     */
    public function findPending(): Collection;

    public function approve(int $id): ?PriceOffer;

    public function reject(int $id): ?PriceOffer;

    public function expireOld(): int;
}
