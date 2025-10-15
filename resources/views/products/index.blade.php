@extends('layout.master')

@section('page-title', 'Elenco prodotti')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h3 class="text-lg font-semibold mb-2">Benvenuto</h3>
        @auth
            <a href="{{ route('products.create') }}"
               class="bg-blue-500 w-8 px-4 py-2 text-white rounded rounded-md hover:bg-blue-700 my-8">Crea prodotto</a>
        @endauth
        <table class="w-full">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Prezzo</th>
                <th>Data creazione</th>
                <th>Data modifica</th>
                <th>Azioni</th>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->formatted_price }}</td>
                    <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @can('edit', $product)
                            <a href="{{ route('products.edit', $product) }}">Modifica</a>
                        @endcan
                        @can('destroy', $product)
                            <form method="post" action="{{ route('products.destroy', $product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Cancella</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>

        <section class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-white border rounded-md">Contenuto 1</div>
            <div class="p-4 bg-white border rounded-md">Contenuto 2</div>
        </section>
    </div>
@endsection
