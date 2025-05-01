<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcard extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'template', 'message', 'method', 'file_path', 'order_item_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
{
    return $this->belongsTo(\App\Models\OrderItem::class);
}


}
