<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'variations'
    ];

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }
}
