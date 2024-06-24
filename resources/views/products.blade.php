<x-layout>
    <x-slot:title>Products</x-slot:title>

    <div class="w3-content">
        <div class="w3-container w3-card w3-padding">
            @if(isset($products) && $products)
                <h2>Available products:</h2>
                <div class="w3-padding w3-margin">
                    @foreach($products as $product)
                        <a href="{{ url('products/' . $product->id) }}" class="w3-column w3-card w3-padding w3-hover-grey" style="text-decoration: unset; margin-top: 1em;">{{ $product->name }}</a>
                    @endforeach
                </div>
            @else
                <h2>There are no products at this time.</h2>
            @endif

            <div class="w3-padding">
                <a href="{{ url('products/create') }}" class="w3-button w3-theme">Create a product</a>
            </div>
        </div>

        <br/><br/>

        <div class="w3-container w3-card w3-padding">
            <h2>Dispatch a discount job?</h2>

            <form class="w3-padding" id="form-discount" action="{{ url('products/discount') }}" method="POST">
                @csrf {{-- Cross-Site Request Forgery protection. --}}
                Discount: <input id="input-discount-percentage" name="percentage" type="number" step="any" value="0">%

                <button class="w3-button w3-theme w3-margin" type="submit">Dispatch</button>
            </form>
        </div>
    </div>
</x-layout>
