<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password',
        'role', 'avatar', 'address', 'city', 'country'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function sendPasswordResetNotification($token)
{
    $this->notify(new ResetPasswordNotification($token));
}
public function wishlist()
{
    return $this->hasMany(Wishlist::class);
}
// app/Models/User.php
protected $appends = ['avatar_url'];

public function getAvatarUrlAttribute()
{
    return $this->avatar ? asset('storage/' . $this->avatar) : null;
}
}