<?php

namespace App\Enums;

enum UserRole: string
{
    case Farmer = 'farmer';
    case Admin = 'admin';
    case CooperativeAdmin = 'cooperative_admin';

    public function label(): string
    {
        return match ($this) {
            self::Farmer => 'Caficultor',
            self::Admin => 'Administrador',
            self::CooperativeAdmin => 'Admin de cooperativa',
        };
    }
}
