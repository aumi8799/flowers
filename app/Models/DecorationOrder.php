<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecorationOrder extends Model
{
    use HasFactory;

    // Galimos statusų reikšmės
    const STATUS_PATEIKTAS = 'pateiktas';
    const STATUS_VYKDOMAS = 'vykdomas';
    const STATUS_ATMESTAS = 'atmestas';
    const STATUS_ATLIKTAS = 'atliktas';


    protected $fillable = [
        'event_date', 'location', 'guests_count', 'tables_count', 'flowers', 'color_scheme',
        'style', 'budget', 'name', 'email', 'comments', 'package', 'type', 'status'
    ];
}
