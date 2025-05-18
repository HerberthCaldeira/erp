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
        'starts_at',
        'expires_at',
    ];

    public function scopeValid($query)
    {
        return $query->where('status', 'enable')         
            ->where('starts_at', '<', now())
            ->where('expires_at', '>', now());
    }
}
