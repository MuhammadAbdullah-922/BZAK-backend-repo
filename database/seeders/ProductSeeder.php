<?php
namespace Database\Seeders;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id'       => 1,
                'name'              => 'Bzack Classic Tee',
                'price'             => 1299,
                'sale_price'        => 999,
                'short_description' => 'Premium cotton classic t-shirt',
                'description'       => 'Made from 100% premium cotton for ultimate comfort',
                'sku'               => 'BZK-TEE-001',
                'is_featured'       => true,
                'is_new'            => true,
                'sizes'             => ['S', 'M', 'L', 'XL', 'XXL'],
                'colors'            => ['Black', 'White', 'Navy'],
                'images'            => ['products/tee1.jpg'],
            ],
            [
                'category_id'       => 1,
                'name'              => 'Bzack Graphic Tee',
                'price'             => 1499,
                'sale_price'        => null,
                'short_description' => 'Unique graphic print t-shirt',
                'description'       => 'Bold graphic prints on premium fabric',
                'sku'               => 'BZK-TEE-002',
                'is_featured'       => true,
                'is_new'            => true,
                'sizes'             => ['S', 'M', 'L', 'XL'],
                'colors'            => ['Black', 'White'],
                'images'            => ['products/tee2.jpg'],
            ],
            [
                'category_id'       => 2,
                'name'              => 'Bzack Premium Hoodie',
                'price'             => 3499,
                'sale_price'        => 2999,
                'short_description' => 'Heavyweight fleece hoodie',
                'description'       => 'Ultra soft heavyweight fleece for maximum warmth',
                'sku'               => 'BZK-HOD-001',
                'is_featured'       => true,
                'is_new'            => false,
                'sizes'             => ['S', 'M', 'L', 'XL', 'XXL'],
                'colors'            => ['Black', 'Grey', 'Olive'],
                'images'            => ['products/hoodie1.jpg'],
            ],
            [
                'category_id'       => 3,
                'name'              => 'Bzack Slim Fit Jeans',
                'price'             => 2999,
                'sale_price'        => null,
                'short_description' => 'Premium slim fit denim jeans',
                'description'       => 'Modern slim fit cut in premium stretch denim',
                'sku'               => 'BZK-JNS-001',
                'is_featured'       => false,
                'is_new'            => true,
                'sizes'             => ['28', '30', '32', '34', '36'],
                'colors'            => ['Blue', 'Black', 'Grey'],
                'images'            => ['products/jeans1.jpg'],
            ],
            [
                'category_id'       => 4,
                'name'              => 'Bzack Bomber Jacket',
                'price'             => 5999,
                'sale_price'        => 4999,
                'short_description' => 'Classic bomber jacket',
                'description'       => 'Premium quality bomber jacket for all seasons',
                'sku'               => 'BZK-JKT-001',
                'is_featured'       => true,
                'is_new'            => true,
                'sizes'             => ['S', 'M', 'L', 'XL'],
                'colors'            => ['Black', 'Olive', 'Brown'],
                'images'            => ['products/jacket1.jpg'],
            ],
            [
                'category_id'       => 5,
                'name'              => 'Bzack Cargo Shorts',
                'price'             => 1799,
                'sale_price'        => null,
                'short_description' => 'Comfortable cargo shorts',
                'description'       => 'Multi-pocket cargo shorts for everyday wear',
                'sku'               => 'BZK-SHT-001',
                'is_featured'       => false,
                'is_new'            => true,
                'sizes'             => ['S', 'M', 'L', 'XL', 'XXL'],
                'colors'            => ['Khaki', 'Black', 'Olive'],
                'images'            => ['products/shorts1.jpg'],
            ],
        ];

        foreach ($products as $productData) {
            $sizes  = $productData['sizes'];
            $colors = $productData['colors'];

            unset($productData['sizes'], $productData['colors']);

            $product = Product::create([
                ...$productData,
                'slug'        => Str::slug($productData['name']) . '-' . Str::random(5),
                'sizes'       => $sizes,
                'colors'      => $colors,
                'is_active'   => true,
                'meta_title'  => $productData['name'] . ' | Bzack',
            ]);

            // Create Inventory
            foreach ($sizes as $size) {
                foreach ($colors as $color) {
                    Inventory::create([
                        'product_id'      => $product->id,
                        'size'            => $size,
                        'color'           => $color,
                        'quantity'        => rand(5, 50),
                        'low_stock_alert' => 5,
                    ]);
                }
            }
        }
    }
}