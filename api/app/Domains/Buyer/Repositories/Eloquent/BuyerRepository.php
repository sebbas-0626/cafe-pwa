<?php

namespace App\Domains\Buyer\Repositories\Eloquent;

use App\Domains\Buyer\Models\Buyer;
use App\Domains\Buyer\Repositories\Contracts\BuyerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BuyerRepository implements BuyerRepositoryInterface
{
    public function findActiveWithApprovedOffers(): Collection
    {
        return Buyer::query()
            ->where('is_active', true)
            ->with([
                'priceOffers' => fn ($query) => $query->approvedAndValid(),
                'priceOffers.coffeeVariety',
            ])
            ->get();
    }

    public function findById(int $id): ?Buyer
    {
        return Buyer::find($id);
    }

    public function create(array $data): Buyer
    {
        return Buyer::create($data);
    }

    public function update(int $id, array $data): ?Buyer
    {
        $buyer = Buyer::find($id);

        if ($buyer === null) {
            return null;
        }

        $buyer->update($data);

        return $buyer->refresh();
    }
}
