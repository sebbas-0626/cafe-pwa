<?php

namespace App\Domains\CoffeeVariety\Policies;

use App\Domains\CoffeeVariety\Models\CoffeeVariety;
use App\Enums\UserRole;
use App\Models\User;

class CoffeeVarietyPolicy
{
    public function before(User $user): ?bool
    {
        return $user->role === UserRole::Admin ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->buyer_id !== null;
    }

    public function view(User $user, CoffeeVariety $coffeeVariety): bool
    {
        return $user->buyer_id !== null;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, CoffeeVariety $coffeeVariety): bool
    {
        return false;
    }

    public function delete(User $user, CoffeeVariety $coffeeVariety): bool
    {
        return false;
    }
}
