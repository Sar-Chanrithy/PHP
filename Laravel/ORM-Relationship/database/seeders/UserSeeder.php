<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Rithy', 'email' => 'rithy@gmail.com'],
            ['name' => 'Dara', 'email' => 'dara@gmail.com'],
            ['name' => 'Sokha', 'email' => 'sokha@gmail.com'],
            ['name' => 'Vanna', 'email' => 'vanna@gmail.com'],
            ['name' => 'Sophea', 'email' => 'sophea@gmail.com'],
            ['name' => 'Bopha', 'email' => 'bopha@gmail.com'],
            ['name' => 'Pisey', 'email' => 'pisey@gmail.com'],
            ['name' => 'Sreymom', 'email' => 'sreymom@gmail.com'],
            ['name' => 'Chenda', 'email' => 'chenda@gmail.com'],
            ['name' => 'Sovann', 'email' => 'sovann@gmail.com'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('12345678'),
                ]
            );
        }
    }
}