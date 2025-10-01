<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Prezzo</th>
        <th>Data creazione</th>
        <th>Data modifica</th>
    </tr>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ \Illuminate\Support\Number::currency($product->price / 100) }}</td>
            <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
        </tr>
    @endforeach
</table>
