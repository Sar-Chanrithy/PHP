<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Laptops',
            'Smartphones',
            'Tablets',
            'Monitors',
            'Keyboards',
            'Mice',
            'Headphones',
            'Speakers',
            'Printers',
            'Accessories'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category
            ]);
        }
    }
}