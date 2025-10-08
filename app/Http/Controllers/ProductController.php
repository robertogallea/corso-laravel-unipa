<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
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
