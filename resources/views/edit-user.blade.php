@php
    /** @var \App\Models\User $user */
        $editor = Illuminate\Support\Facades\Auth::user();
        $admin = $editor->isAdmin();
@endphp
@extends('layouts/main-layout')

@section('title', 'Редактирование пользователя')

@section('content')
    <div class="container mt-5">
            <h2 class="text-center mb-4">Редактирование пользователя</h2>
        <form id="editUser" method="post" action="{{ route('Users.editUserRoute') }}" class="mx-auto" style="max-width: 400px;">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" placeholder="Введите имя" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control" id="login" name="login" value="{{$user->login}}" placeholder="Введите логин" required autocomplete="off">
            </div>

            @admin
                <label for="role" class="form-label">Роль</label>
                <input type="text" class="form-control" id="role" name="role" value="{{$user->role}}" placeholder="Роль пользователя" required>
                <label for="email" class="form-label">Статус</label>
                <input type="number" class="form-control" id="status" name="status" value="{{$user->status}}" placeholder="Статус пользователя"
                       required>
            @endadmin

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
                <button type="submit" class="btn btn-primary w-100">Обновить данные</button>
        </form>
    </div>

@endsection

