@php

    $user= Illuminate\Support\Facades\Auth::user();
    $admin = $user->isAdmin();
    $route = $admin? 'createUserRoute' : 'registerRoute';
    $title = $admin? 'Создание пользователя' : 'Регистрация';
    $formId =$admin? 'createUserFormForm' : 'registerForm'
@endphp
@extends('layouts/main-layout')

@section('title', $title)

@section('content')
    <div class="container mt-5">
        @if($admin)
            <h2 class="text-center mb-4">Создание нового польователя</h2>
        @else
            <h2 class="text-center mb-4">Регистрация</h2>
        @endif
        <form id="{{$formId}}" method="post" action="{{ route($route) }}" class="mx-auto" style="max-width: 400px;">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Введите имя" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control" id="login" name="login" placeholder="Введите логин" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Введите email" required>
            </div>

            @if($admin)
                <label for="role" class="form-label">Роль</label>
                <input type="text" class="form-control" id="role" name="role" placeholder="Роль пользователя" required>
                <label for="email" class="form-label">Статус</label>
                <input type="number" class="form-control" id="status" name="status" placeholder="Статус пользователя"
                       required>
            @endif

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль"
                       required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Подтверждение пароля</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                       placeholder="Подтвердите пароль" required>
            </div>
            @if($admin)
                <button type="submit" class="btn btn-primary w-100">Создать пользователя</button>
            @else
                <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
            @endif
        </form>
    </div>

@endsection

