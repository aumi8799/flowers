<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id', 'points', 'description', 'used_loyalty_points'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
{
    return $this->belongsTo(Order::class);
}

}
