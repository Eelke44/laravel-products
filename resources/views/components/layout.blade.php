<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Todo Manager' }}</title>
    {{-- Uncomment to use local styles --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

@php
    $user = auth()->user();
@endphp

<body class="w3-theme-l5" style="max-width:1400px; margin-top:80px">
    <div class="w3-top">
        <div class="w3-bar w3-left-align w3-large w3-theme-d4">
            @if(isset($user) && $user->name)
                <div class="w3-bar-item w3-padding-large w3-theme-d2 w3-center">
                    Welcome {{ $user->name }}.
                </div>
            @else
                <div class="w3-bar-item w3-padding-large w3-theme-d2 w3-center">
                    <a href="{{ url('login') }}">You are not logged in.</a>
                </div>
            @endif
            <a href="{{ url('/') }}" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">
                <i class="fa fa-home"></i>
            </a>
        </div>
    </div>

    <div class="w3-container w3-content">
        {{ $slot }}
    </div>
</body>
