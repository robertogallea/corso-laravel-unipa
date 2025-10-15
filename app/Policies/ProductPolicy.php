<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function before(User $user, $ability)
    {
        return null;
    }

    public function after(User $user, $ability)
    {
        return null;
    }

    public function index(?User $user)
    {
        return true;
    }

    public function show(User $user, Product $product)
    {
        return true;
    }


    public function create(User $user)
    {
        return true;
    }

    public function destroy(User $user, Product $product)
    {
        // massimo un giorno fa
        return $product->created_at->gte(now()->subDay());
    }
    public function edit(?User $user, Product $product)
    {
        return $product->price <= 500 ?
            Response::allow() :
            Response::denyAsNotFound();
    }

//    GET / list             -> index()
//    GET /{id} show         -> show()
//    GET /create create     -> create()
//    POST / store           -> create()
//    DELETE /{id} delete    -> destroy()
//    GET /{id}/edit edit    -> edit()
//    PATCH|PUT /{id} update -> edit()
//
//    PATCH /{id}/publish
//
//    POST /published-products
//    DELETE /published-products/{id}
}
