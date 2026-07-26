<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'minimum_order',
        'usage_limit', 'used_count', 'is_active', 'expires_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'date',
    ];
}