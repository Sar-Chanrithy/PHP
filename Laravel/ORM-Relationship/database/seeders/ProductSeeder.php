<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['category' => 'Laptops', 'title' => 'ASUS ROG Strix G17', 'price' => 850],
            ['category' => 'Laptops', 'title' => 'Dell XPS 15', 'price' => 1200],
            ['category' => 'Smartphones', 'title' => 'iPhone 15 Pro', 'price' => 999],
            ['category' => 'Smartphones', 'title' => 'Samsung Galaxy S24', 'price' => 899],
            ['category' => 'Tablets', 'title' => 'iPad Air', 'price' => 599],
            ['category' => 'Monitors', 'title' => 'LG UltraGear 27', 'price' => 299],
            ['category' => 'Keyboards', 'title' => 'Logitech MX Keys', 'price' => 120],
            ['category' => 'Mice', 'title' => 'Logitech G502', 'price' => 65],
            ['category' => 'Headphones', 'title' => 'Sony WH-1000XM5', 'price' => 350],
            ['category' => 'Speakers', 'title' => 'JBL Flip 6', 'price' => 129],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->firstOrFail();

            Product::updateOrCreate(
                ['title' => $product['title']],
                [
                    'category_id' => $category->id,
                    'price' => $product['price']
                ]
            );
        }
    }
}