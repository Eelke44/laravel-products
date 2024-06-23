<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $product ? $product->name : 'Product not found' }}</title>
</head>
<body>
    @if($product)
        <form action="{{ url('products/'.$product->id.'/update') }}" method="POST">
            @method('PUT')  {{-- HTTP method override, since forms don't support PUT natively. --}}
            @csrf           {{-- Cross-Site Request Forgery protection. --}}
            <h2>Update {{ $product->name }}</h2>
    
            Name: <input id="input-name" name="name" type="text" value={{ $product->name }} required>
            <br/><br/>
            Description: <textarea id="input-decription" name="description" required>{{ $product->description }}</textarea>
            <br/><br/>
            
            Price: €<input id="input-price" name="price" type="number" step="0.01" min="0" value={{ $product->price }} required>
            <br/><br/>
    
            <input type=hidden name="id" value={{ $product->id }}>
            <br/><br/>

            <button type="submit">Update</button> <a href="{{ url('products/'.$product->id) }}">Cancel</a>
        </form>
        
    @else
        <span>Product not found</span>
    @endif
</body>
</html>
