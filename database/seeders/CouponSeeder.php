<?php
namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code'          => 'BZACK10',
                'type'          => 'percentage',
                'value'         => 10,
                'minimum_order' => 1000,
                'usage_limit'   => 100,
                'is_active'     => true,
                'expires_at'    => '2025-12-31',
            ],
            [
                'code'          => 'BZACK20',
                'type'          => 'percentage',
                'value'         => 20,
                'minimum_order' => 2000,
                'usage_limit'   => 50,
                'is_active'     => true,
                'expires_at'    => '2025-12-31',
            ],
            [
                'code'          => 'FLAT200',
                'type'          => 'fixed',
                'value'         => 200,
                'minimum_order' => 1500,
                'usage_limit'   => 200,
                'is_active'     => true,
                'expires_at'    => '2025-12-31',
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}