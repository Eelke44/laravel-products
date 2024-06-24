<x-with-product :product=$product>
    <div class="w3-container w3-card w3-padding">
        <div class="w3-container w3-padding">
            <h4 class="w3-row">Product: {{ $product->name }}</h4>
            {{-- <span class="w3-row w3-padding w3-margin">Product: {{ $product->name }}</span> --}}

            <span class="w3-row w3-padding w3-margin">Description: {{ $product->description }}</span>

            <span class="w3-row w3-padding w3-margin">Price: €{{ number_format($product->price, 2) }}</span>
        </div>
        <div class="w3-container w3-padding">
            <a class="w3-button w3-column" href="{{ url('products/'.$product->id.'/update') }}">Update</a>
            <form id="delete-form" class="w3-column" style="display: contents;" action="{{ url('products/'.$product->id) }}" method="POST">
                @method('DELETE')   {{-- HTTP method override, since forms don't support DELETE natively. --}}
                @csrf               {{-- Cross-Site Request Forgery protection. --}}
                <button type="submit" class="w3-column w3-button w3-red">Delete</button>
            </form>
            <a class="w3-button w3-column w3-right" href="{{ url('products') }}">Back</a>
        </div>
    </div>
</x-with-product>
