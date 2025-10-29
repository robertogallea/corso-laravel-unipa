<?php

namespace App\Http\Controllers;

use App\Events\CheapProductCreated;
use App\Events\ExpensiveProductCreated;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::paginate(perPage: 20, pageName: 'products_page')
            ->withQueryString()
            ->fragment('products');


        $cheapProducts = Product::where('price', '<', 100000)
            ->paginate(perPage: 5, pageName: 'cheap_products_page')
            ->withQueryString()
            ->fragment('cheap_products');

        return view('products.index', compact('products', 'cheapProducts'));
    }

    public function create()
    {
        $product = new Product();

        return view('products.edit', compact('product'));
    }

    public function store(StoreProductRequest $request)
    {
//        $product = new Product([
//            'name' => $request->name,
//            'price' => $request->price,
//        ]);
//
//        $product->save();

//        $request->validate([
//            'name' => 'required|string|min:3',
//            'price' => 'required|numeric|min:0.01|max:999.99',
//        ], [
//            'name' => [
//                'required' => 'Devi inserire un nome per :attribute',
//                'string' => 'Il campo :attribute deve essere una stringa valida',
//                'min' => 'Il campo nome :attribute essere di almeno 3 caratteri'
//            ]
//        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        if ($product->price > 10) {
            ExpensiveProductCreated::dispatch($product);
        } elseif ($product->price < 5) {
            CheapProductCreated::dispatch($product);
        }

        return redirect()->route('products.index');

    }

    public function edit(Product $product)
    {
//        Gate::authorize('edit-product', $product);

        return view('products.edit', compact('product'));
    }

    public function update(Product $product, StoreProductRequest $request)
    {
//        Gate::authorize('edit-product', $product);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
