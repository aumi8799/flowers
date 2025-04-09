<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'delivery_city', 'total_price', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
