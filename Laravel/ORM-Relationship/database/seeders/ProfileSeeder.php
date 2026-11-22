<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            ['phone' => '012345678', 'address' => 'Phnom Penh'],
            ['phone' => '098765432', 'address' => 'Siem Reap'],
            ['phone' => '011223344', 'address' => 'Battambang'],
            ['phone' => '088334455', 'address' => 'Kampot'],
            ['phone' => '096445566', 'address' => 'Kandal'],
            ['phone' => '097556677', 'address' => 'Takeo'],
            ['phone' => '015667788', 'address' => 'Kampong Cham'],
            ['phone' => '016778899', 'address' => 'Prey Veng'],
            ['phone' => '017889900', 'address' => 'Pursat'],
            ['phone' => '018990011', 'address' => 'Sihanoukville'],
        ];

        $users = User::orderBy('id')->take(10)->get();

        foreach ($users as $index => $user) {
            Profile::updateOrCreate(
                ['user_id' => $user->id],
                $profiles[$index]
            );
        }
    }
}