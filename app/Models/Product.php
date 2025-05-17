<?php

namespace App\Models;

use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Money::fromCents($value),
            set: fn (string $value) => Money::fromString($value)->toCents()
        );
    }


}
