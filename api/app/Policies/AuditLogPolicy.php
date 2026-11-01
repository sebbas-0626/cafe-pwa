<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\AuditLog;
use App\Models\User;

class AuditLogPolicy
{
    public function before(User $user): ?bool
    {
        return $user->role === UserRole::Admin ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, AuditLog $model): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, AuditLog $model): bool
    {
        return false;
    }

    public function delete(User $user, AuditLog $model): bool
    {
        return false;
    }
}
