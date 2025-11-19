<x-mail::message>
# Nuovo prodotto creato

{{ $product->name }}

<x-mail::button :url="route('products.edit', $product)">
Visualizza prodotto
</x-mail::button>

Grazie,<br>
{{ config('app.name') }}
</x-mail::message>
