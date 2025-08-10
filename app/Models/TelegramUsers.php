<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUsers extends Model
{
    protected $fillable = [
        'telegram_id',
        'credit',
    ];
}
