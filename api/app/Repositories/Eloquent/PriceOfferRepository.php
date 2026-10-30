<?php

namespace App\Repositories\Eloquent;

use App\Models\PriceOffer;
use App\Repositories\Contracts\PriceOfferRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PriceOfferRepository implements PriceOfferRepositoryInterface
{
    public function findApprovedByVariety(int $varietyId): Collection
    {
        return PriceOffer::query()
            ->where('coffee_variety_id', $varietyId)
            ->approvedAndValid()
            ->with(['buyer', 'coffeeVariety'])
            ->orderBy('price_per_kg')
            ->get();
    }

    public function findPending(): Collection
    {
        return PriceOffer::query()
            ->where('status', 'pending')
            ->with(['buyer', 'coffeeVariety'])
            ->orderBy('created_at')
            ->get();
    }

    public function approve(int $id): ?PriceOffer
    {
        return $this->changeStatus($id, 'approved');
    }

    public function reject(int $id): ?PriceOffer
    {
        return $this->changeStatus($id, 'rejected');
    }

    public function expireOld(): int
    {
        return PriceOffer::query()
            ->whereIn('status', ['pending', 'approved'])
            ->where('valid_until', '<', now())
            ->update(['status' => 'expired']);
    }

    private function changeStatus(int $id, string $status): ?PriceOffer
    {
        $offer = PriceOffer::find($id);

        if ($offer === null) {
            return null;
        }

        $offer->update(['status' => $status]);

        return $offer->refresh();
    }
}
