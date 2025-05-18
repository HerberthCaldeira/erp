<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'freight',
        'discount',
        'total',
        'email',
        'zipcode',
        'address',
        'address_number',
        'address_complement',
        'address_district',
        'address_city',
        'address_state',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
