<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $fillable = [
        'title',
        'code',
        'discount',
        'valid_until',
        'description',
        'image',
    ];
}
