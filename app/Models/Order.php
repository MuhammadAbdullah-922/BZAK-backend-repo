<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'status', 'subtotal', 'discount',
        'shipping', 'total', 'payment_method', 'payment_status',
        'coupon_code', 'shipping_address', 'shipping_city',
        'shipping_phone', 'notes', 'whatsapp_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}