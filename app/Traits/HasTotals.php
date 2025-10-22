<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasTotals
{
    public function scopeWithTotalPrice($query)
    {
        $query->addSelect([
            'total_price' => Product::selectRaw('SUM(products.price * movement_product.qty)')
                ->join('movement_product', 'movement_product.product_id', '=', 'products.id')
                ->whereColumn('movement_product.movement_id', '=', 'movements.id')
        ]);
    }

    public function totalPrice(): Attribute
    {
        return Attribute::make(get: fn($value) => $value / 100);
    }

    public function formattedTotalPrice(): Attribute
    {
        return Attribute::make(get: fn() => \Number::currency($this->total_price));
    }
}
