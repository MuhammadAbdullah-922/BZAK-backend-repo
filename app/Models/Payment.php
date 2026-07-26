<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'transaction_id', 'sender_number',
        'bank_reference', 'proof_image', 'amount', 'method', 'status',
        'verified_by', 'verified_at', 'notes'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    protected $appends = ['proof_image_url'];

    /**
     * Full, browser-usable URL for the uploaded screenshot.
     * Frontend should read `proof_image_url`, not the raw `proof_image` path.
     */
    public function getProofImageUrlAttribute()
    {
        return $this->proof_image
            ? asset('storage/' . $this->proof_image)
            : null;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}