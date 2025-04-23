<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'category', 'size', 'duration', 'price', 'start_date', 'status', 'order_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
{
    return $this->belongsTo(Order::class);
}

}
