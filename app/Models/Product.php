<?php

namespace App\Models;

use App\Models\Scopes\PriceLesserThan5000;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ScopedBy(PriceLesserThan5000::class)] // Scope globale applicato tramite PHP Attribute
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

//    protected $fillable = ['name', 'price']; // disabilita la protezione per 'name' e 'price'
//    protected $guarded = null; // abilita la protezione per nessun attributo
//    protected $fillable = ['*']; // disabilita la protezione per tutti gli attributi


    protected static function booted()
    {
//        // Global scope anonimi
//        static::addGlobalScope('price_lesser_than_50_000', function (Builder $builder) {
//           $builder->where('price', '<', 50_000_00);
//        });
//
//        // Global scope con classe
//        static::addGlobalScope(new PriceLesserThan5000());
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }

    public function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => \Illuminate\Support\Number::currency($this->price),
        );
    }

    public function movements(): BelongsToMany
    {
        return $this->belongsToMany(Movement::class);
    }
}
