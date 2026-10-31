<?php

namespace App\Domains\Buyer\Policies;

use App\Domains\Buyer\Models\Buyer;
use App\Enums\UserRole;
use App\Models\User;

class BuyerPolicy
{
    public function before(User $user): ?bool
    {
        return $user->role === UserRole::Admin ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->buyer_id !== null;
    }

    public function view(User $user, Buyer $buyer): bool
    {
        return $user->buyer_id !== null && (int) $user->buyer_id === (int) $buyer->id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Buyer $buyer): bool
    {
        return false;
    }

    public function delete(User $user, Buyer $buyer): bool
    {
        return false;
    }
}
