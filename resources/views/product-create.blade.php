<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a product</title>
</head>
<body>
    <h2>Create a product</h2>
    <form action="{{ url('products') }}" method="POST">
        @csrf           {{-- Cross-Site Request Forgery protection. --}}

        Name: <input id="input-name" name="name" type="text" placeholder="Name" required>
        <br/><br/>

        Description: <textarea id="input-decription" name="description" placeholder="Description" required></textarea>
        <br/><br/>
        
        Price: €<input id="input-price" name="price" type="number" step="0.01" min="0" placeholder="0.00" required>
        <br/><br/>

        <button type="submit">Create</button> <a href="{{ url('products') }}">Cancel</a>
    </form>
</body>
</html>
