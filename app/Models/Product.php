<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

//    protected $fillable = ['name', 'price']; // disabilita la protezione per 'name' e 'price'
//    protected $guarded = null; // abilita la protezione per nessun attributo
//    protected $fillable = ['*']; // disabilita la protezione per tutti gli attributi

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => \Illuminate\Support\Number::currency($this->price),
        );
    }
}
