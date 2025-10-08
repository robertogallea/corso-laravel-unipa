@extends('layout.master')

@section('page-title', $product->exists ? $product->name : 'Nuovo prodotto')

@section('content')
    <form action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}" method="post">
        @csrf
        @method($product->exists ? 'PATCH' : 'POST')
        <div class="p-4">
            <label for="name">Nome:</label>
            <input class="border border-blue-500" type="text" name="name" value="{{ old('name', $product->name) }}"/>
            @error('name')
            <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="p-4">
            <label for="price">Prezzo:</label>
            <input class="border border-blue-500" type="text" name="price" value="{{ old('price', $product->price) }}"/>
            @error('price')
            <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <button class="bg-blue-500 px-4 py-2 text-white rounded rounded-md hover:bg-blue-700 my-8"
                    type="submit">
                @if ($product->exists)
                    Aggiorna prodotto
                @else
                    Crea prodotto
                @endif
            </button>
        </div>
    </form>
@endsection
