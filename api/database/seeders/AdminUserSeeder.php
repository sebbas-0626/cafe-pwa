<?php

namespace Database\Seeders;

use App\Domains\Buyer\Models\Buyer;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'sebastiantovar26@gmail.com'],
            [
                'name' => 'Sebastián Tovar',
                'password' => 'sebbas0626',
                'role' => UserRole::Admin,
                'is_verified' => true,
            ],
        );

        $cooperativeBuyer = Buyer::where('name', 'Cooperativa Caficultores de Huila')->first();

        User::updateOrCreate(
            ['email' => 'cooperativa@cafeprecios.test'],
            [
                'name' => 'Admin Cooperativa Caficultores de Huila',
                'password' => 'cooperativa123',
                'role' => UserRole::CooperativeAdmin,
                'is_verified' => true,
                'buyer_id' => $cooperativeBuyer?->id,
            ],
        );
    }
}
