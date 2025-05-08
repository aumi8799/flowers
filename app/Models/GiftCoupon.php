<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCoupon extends Model
{
    protected $fillable = ['code', 'value', 'used', 'order_id','used_in_order_id' ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
