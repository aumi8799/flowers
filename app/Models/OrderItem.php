<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'custom_bouquet_id', 'quantity', 'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function postcard()
    {
        return $this->hasOne(\App\Models\Postcard::class);
    }
    public function customBouquet()
{
    return $this->belongsTo(\App\Models\CustomBouquet::class);
}

}
