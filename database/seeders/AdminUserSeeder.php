<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'aletheiaresourcecenter@gmail.com'],
            [
                'name' => 'Aletheia Resource Center',
                'password' => Hash::make('Password@123'),
            ]
        );

        User::query()->firstOrCreate(
            ['email' => 'lemuelyee@gmail.com'],
            [
                'name' => 'Another User',
                'password' => Hash::make('Password@123'),
            ]
        );
    }
}
