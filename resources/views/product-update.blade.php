<x-with-product :product=$product>
    <div class="w3-container w3-card w3-padding">
        <form action="{{ url('products/'.$product->id.'/update') }}" method="POST">
            @method('PUT')  {{-- HTTP method override, since forms don't support PUT natively. --}}
            @csrf           {{-- Cross-Site Request Forgery protection. --}}
            
            <div class="w3-container w3-padding">
                <h2>Update {{ $product->name }}</h2>
                
                <div class="w3-row w3-padding w3-margin">
                    Name: <input id="input-name" name="name" type="text" value={{ $product->name }} required></input>
                </div>

                <div class="w3-row w3-padding w3-margin">
                    Price: €<input id="input-price" name="price" type="number" step="0.01" min="0" value={{ round($product->price, precision: 2) }} required></input>
                </div>

                <div class="w3-container w3-row w3-padding w3-margin">
                    <div class="w3-column">
                        Description:
                    </div>
                    <textarea id="input-decription" class="w3-column" style="width: -webkit-fill-available;" name="description" required>{{ $product->description }}</textarea>
                </div>

                <input type=hidden name="id" value={{ $product->id }}>
            </div>
    
            <div class="w3-container w3-padding">
                <button class="w3-button" type="submit">Update</button> <a class="w3-button" href="{{ url('products/'.$product->id) }}">Cancel</a>
            </div>
        </form>
    </div>
</x-with-product>