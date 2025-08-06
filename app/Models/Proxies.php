<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proxies extends Model
{
    protected $fillable = [
        'ip',
        'port',
        'type',
        'username',
        'password',
        'country',
        'active',
        'last_checked_at',
    ];
}
