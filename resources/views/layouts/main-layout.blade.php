<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>


    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

</head>
<body>

<header>
    <nav>
        <ul>
{{--            <li><a href="{{ route('home') }}">Home</a></li>--}}
{{--            <li><a href="{{ route('about') }}">About</a></li>--}}
{{--            <li><a href="{{ route('contact') }}">Contact</a></li>--}}
        </ul>
    </nav>
</header>


<main>
    @yield('content')
</main>


<footer>
    <p>&copy; {{ date('Y') }} My Laravel App</p>
</footer>

{{-- Подключение скриптов --}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
