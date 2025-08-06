<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_id',
        'number',
        'amount',
        'date_of_payment',
        'date_of_accept',
        'status',
        'telegram_id',
    ];
}