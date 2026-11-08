<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Laptop',
                'price' => 500,
                'qty' => 10,
                'image' => 'laptop.jpg',
            ],
            [
                'name' => 'Mouse',
                'price' => 15,
                'qty' => 20,
                'image' => 'mouse.jpg',
            ],
            [
                'name' => 'Keyboard',
                'price' => 30,
                'qty' => 15,
                'image' => 'keyboard.jpg',
            ],
        ]);
    }
}