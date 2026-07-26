<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'T-Shirts',
                'description' => 'Casual and stylish t-shirts',
                'image'       => 'categories/tshirts.jpg',
            ],
            [
                'name'        => 'Hoodies',
                'description' => 'Premium quality hoodies',
                'image'       => 'categories/hoodies.jpg',
            ],
            [
                'name'        => 'Jeans',
                'description' => 'Trendy denim jeans',
                'image'       => 'categories/jeans.jpg',
            ],
            [
                'name'        => 'Jackets',
                'description' => 'Stylish jackets for all seasons',
                'image'       => 'categories/jackets.jpg',
            ],
            [
                'name'        => 'Shorts',
                'description' => 'Comfortable casual shorts',
                'image'       => 'categories/shorts.jpg',
            ],
            [
                'name'        => 'Accessories',
                'description' => 'Caps, belts and more',
                'image'       => 'categories/accessories.jpg',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name'        => $category['name'],
                'slug'        => Str::slug($category['name']),
                'description' => $category['description'],
                'image'       => $category['image'],
                'is_active'   => true,
            ]);
        }
    }
}