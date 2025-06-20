<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'delivery_city', 
        'total_price', 
        'status',
        'first_name',      // Pridėtas vardas
        'last_name',       // Pridėtas pavardė
        'phone',           // Pridėtas telefono numeris
        'email',           // Pridėtas el. paštas
        'delivery_address', // Pridėtas pristatymo adresas
        'postal_code',     // Pridėtas pašto kodas
        'delivery_date',
        'delivery_time',
        'notes',           // Pridėtos pastabos
        'video',
        'video_path',
    ];

    // Ryšys su užsakymo prekėmis
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function postcard()
    {
        return $this->hasOne(\App\Models\Postcard::class, 'order_id', 'id');
    }
    public function bouquets()
    {
        return $this->hasMany(\App\Models\CustomBouquet::class);
    }
    public function giftCoupons()
    {
        return $this->hasMany(\App\Models\GiftCoupon::class);
    }
    public function usedGiftCoupon()
{
    return \App\Models\GiftCoupon::where('used_in_order_id', $this->id)->first();
}

    public function loyaltyUsage()
{
    return $this->hasOne(LoyaltyPoint::class)->where('used_loyalty_points', '>', 0);
}
public function earnedLoyaltyPoints()
{
    return $this->hasOne(\App\Models\LoyaltyPoint::class, 'order_id')
        ->where('points', '>', 0);
}

}
