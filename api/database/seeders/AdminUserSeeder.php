<?php

namespace Database\Seeders;

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
    }
}
