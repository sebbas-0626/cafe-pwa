<?php

namespace Database\Seeders;

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
                'role' => 'super_admin',
                'is_verified' => true,
            ],
        );
    }
}
