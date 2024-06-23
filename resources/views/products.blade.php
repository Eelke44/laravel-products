<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
</head>
<body>
    <span>Welcome {{ $user->name }}.</span>

    @if($products)
        <h2>Available products:</h2>
        <div>
            <ul>
                @foreach($products as $product)
                    <li><a href="{{ url('products/' . $product->id) }}">{{ $product->name }}</a></li>
                @endforeach
            </ul>
        </div>
    @else
        <h2>There are no products at this time.</h2>
    @endif

    <a href="{{ url('products/create') }}">Create a product</a>
</body>
</html>
