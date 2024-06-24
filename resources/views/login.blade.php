<x-layout>
    <x-slot:title>Login</x-slot:title>
    
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
</x-layout>