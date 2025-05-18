<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'status',
        'type',
        'value',
        'limit',
        'starts_at',
        'expires_at',
    ];
}
