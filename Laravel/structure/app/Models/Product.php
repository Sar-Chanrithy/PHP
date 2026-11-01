<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product
{
    public static function all()
    {
        return [
            [
        'id' => 1,
        'title' => 'ASUS ROG Strix G16',
        'price' => 1499,
        'qty' => 10,
        'image' => 'https://cdn.handheld.guru/2026/10/asus-rog-strix-g16-laptop-drops-600-now-under-1400-with-ryzen-9-9955hx-and-rtx-5060-4c601479-1025x720.webp',
        'description' => 'Powerful gaming laptop with Intel Core i7, NVIDIA RTX 4060, 16GB RAM, 1TB SSD, and 16-inch 165Hz display.'
    ],
    [
        'id' => 2,
        'title' => 'ASUS TUF Gaming A15',
        'price' => 999,
        'qty' => 15,
        'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500',
        'description' => 'Affordable gaming laptop with AMD Ryzen 7, NVIDIA RTX 4050, 16GB RAM, 512GB SSD, and 144Hz display.'
    ],
        ];
    }
}
