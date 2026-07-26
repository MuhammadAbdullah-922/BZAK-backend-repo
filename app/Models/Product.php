<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'short_description',
        'price', 'sale_price', 'sizes', 'colors', 'images', 'sku',
        'is_active', 'is_featured', 'is_new', 'meta_title', 'meta_description'
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}