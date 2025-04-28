<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomBouquet extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'bouquet_data',
        'total_price',
    ];

    protected $casts = [
        'bouquet_data' => 'array', // Kad JSON automatiškai virstų į PHP masyvą
    ];
}