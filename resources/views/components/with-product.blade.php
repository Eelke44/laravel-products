<x-layout>
    <x-slot:title>{{ isset($product) && $product ? $product->name : 'Product not found' }}</x-slot:title>

    @if(isset($product) && $product)
        {{ $slot }}
    @else
        <h4>Product not found</h4>
    @endif
</x-layout>
