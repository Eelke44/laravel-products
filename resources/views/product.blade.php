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
        <span>Product: {{ $product->name }}</span>
        <br/><br/>
        <span>Description: {{ $product->description }}</span>
        <br/><br/>
        <span>Price: €{{ number_format($product->price, 2) }}</span>
        <br/><br/>
        <a href="{{ url('products/'.$product->id.'/update') }}">Update</a> <a href="{{ url('products') }}">Back</a>
        <br/>
        <form id="delete-form" action="{{ url('products/'.$product->id) }}" method="POST">
            @method('DELETE')   {{-- HTTP method override, since forms don't support DELETE natively. --}}
            @csrf               {{-- Cross-Site Request Forgery protection. --}}
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    @else
        <span>Product not found</span>
    @endif
</body>
</html>
