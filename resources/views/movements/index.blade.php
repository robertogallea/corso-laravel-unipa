@extends('layout.master')

@section('page-title', 'Elenco movimenti')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h3 class="text-lg font-semibold mb-2">Elenco movimenti</h3>
        <table class="w-full">
            <tr>
                <th>ID</th>
                <th>Numero di prodotti</th>
                <th>Importo totale</th>
                <th>Azioni</th>
            </tr>
            @foreach($movements as $movement)
                <tr>
                    <td>{{ $movement->id }}</td>
                    <td>{{ $movement->total_qty ?? 0 }}</td>
                    <td>{{ $movement->formatted_total_price }}</td>
                    <td></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
