<?php

namespace App\Domains\PriceOffer\Policies;

use App\Domains\PriceOffer\Models\PriceOffer;
use App\Enums\UserRole;
use App\Models\User;

class PriceOfferPolicy
{
    public function before(User $user): ?bool
    {
        return $user->role === UserRole::Admin ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->buyer_id !== null;
    }

    public function view(User $user, PriceOffer $priceOffer): bool
    {
        return $this->belongsToUserBuyer($user, $priceOffer->buyer_id);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, PriceOffer $priceOffer): bool
    {
        return $this->belongsToUserBuyer($user, $priceOffer->buyer_id);
    }

    public function delete(User $user, PriceOffer $priceOffer): bool
    {
        return false;
    }

    private function belongsToUserBuyer(User $user, ?int $buyerId): bool
    {
        return $user->buyer_id !== null
            && $buyerId !== null
            && (int) $user->buyer_id === (int) $buyerId;
    }
}
