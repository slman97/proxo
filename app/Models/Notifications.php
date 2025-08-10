<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
   protected $fillable = [
        'message',
        'user_id',
        'status',
    ];
}
