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
@php
    use Illuminate\Support\Facades\Auth
@endphp
@auth
    <header>
        <nav class="nav-menu">
            <ul class="nav-menu__list">
                <li class="nav-menu__item"><a href="{{route('indexRoute')}}" class="nav-menu__link">Главная</a></li>
                <li class="nav-menu__item"><a href="#home" class="nav-menu__link">Карта сервера</a></li>
                <li class="nav-menu__item nav-menu__item--has-submenu">
                    @admin
                    <a href="#services" class="nav-menu__link">Администрирование</a>
                    <ul class="nav-menu__submenu">
                        <li class="nav-menu__submenu-item"><a href="{{route('waitConfirmUserListRoute')}}"
                                                              class="nav-menu__submenu-link">Ожидающие пользователи</a>
                        </li>
                        <li class="nav-menu__submenu-item"><a href="{{route('getUsersViewRoute')}}"
                                                              class="nav-menu__submenu-link">Все пользователи</a></li>
                    </ul>
                    @endadmin
                </li>
                <li class="nav-menu__item"><a href="{{route('Users.getProfileViewRoute',[Auth::user()])}}"
                                              class="nav-menu__link">Личный кабинет</a></li>
                <li class="nav-menu__item"><a href="{{route('logoutRoute')}}" class="nav-menu__link">Выйти</a></li>
            </ul>
        </nav>
    </header>
@endauth
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<main>
    @yield('content')
</main>

<div id="popupMessage" class="alert" role="alert"
     style="position: fixed; top: 20px; right: 20px;width: auto;height: auto; z-index: 1050; text-align: center">
</div>
@include('modal.main-modal')


{{--<footer>--}}
{{--    <p style="align-items: center">&copy; {{ date('Y') }} My Laravel App</p>--}}
{{--</footer>--}}

{{-- Подключение скриптов --}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@yield('custom-scripts')
</body>
</html>
