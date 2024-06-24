<x-layout>
    <x-slot:title>Create a product</x-slot:title>

    <div class="w3-container w3-card w3-padding">
        <form action="{{ url('products') }}" method="POST">
            @csrf           {{-- Cross-Site Request Forgery protection. --}}
            
            <div class="w3-container w3-padding">
                <h2>Create a product</h2>
                
                <div class="w3-row w3-padding w3-margin">
                    Name: <input id="input-name" name="name" type="text" placeholder="Name" required></input>
                </div>

                <div class="w3-row w3-padding w3-margin">
                    Price: €<input id="input-price" name="price" type="number" step="0.01" min="0" placeholder="0.00" required></input>
                </div>

                <div class="w3-container w3-row w3-padding w3-margin">
                    <div class="w3-column">
                        Description:
                    </div>
                    <textarea id="input-decription" class="w3-column" style="width: -webkit-fill-available;" name="description" placeholder="Description" required></textarea>
                </div>
            </div>
    
            <div class="w3-container w3-padding">
                <button class="w3-button" type="submit">Create</button> <a class="w3-button" href="{{ url('products') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-layout>