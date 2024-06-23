<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    {{-- Show any errors coming from the backend. E.g., input validation errors. --}}
    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Login form. --}}
    <form id="form-login" action="{{ url('login') }}" method="POST">
        @csrf {{-- Cross-Site Request Forgery protection. --}}
        <h2>Login</h2>

        <input id="input-email" name="email" type="text" placeholder="Email">

        <input id="input-password" name="password" type="password" placeholder="Password">

        <button type="submit">Login</button>
    </form>

</body>
</html>