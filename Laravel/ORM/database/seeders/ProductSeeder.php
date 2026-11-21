<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
        [
            'name' => 'Laptop',
            'price' => 1200.00,
            'qty' => 10,
            'description' => 'Dell Laptop'
        ],
        [
            'name' => 'Mouse',
            'price' => 15.50,
            'qty' => 50,
            'description' => 'Wireless Mouse'
        ],
        [
            'name' => 'Keyboard',
            'price' => 35.00,
            'qty' => 30,
            'description' => 'Mechanical Keyboard'
        ],
        [
            'name' => 'Monitor',
            'price' => 180.00,
            'qty' => 20,
            'description' => '24 Inch Monitor'
        ],
        [
            'name' => 'Headphone',
            'price' => 45.00,
            'qty' => 40,
            'description' => 'Gaming Headphone'
        ],
        [
            'name' => 'USB Flash Drive',
            'price' => 12.00,
            'qty' => 100,
            'description' => '64GB USB Drive'
        ],
        [
            'name' => 'Webcam',
            'price' => 55.00,
            'qty' => 25,
            'description' => 'Full HD Webcam'
        ],
        [
            'name' => 'SSD',
            'price' => 85.00,
            'qty' => 35,
            'description' => '512GB SSD'
        ],
        [
            'name' => 'Speaker',
            'price' => 60.00,
            'qty' => 15,
            'description' => 'Bluetooth Speaker'
        ],
        [
            'name' => 'Laptop Stand',
            'price' => 25.00,
            'qty' => 45,
            'description' => 'Adjustable Laptop Stand'
        ]
    ]);
    }
}
