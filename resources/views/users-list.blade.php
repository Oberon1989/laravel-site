@extends('layouts/main-layout')

@section('title', 'Список пользователей')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Список пользователей</h1>
        @foreach($users as $user)
            <div class="row align-items-center mb-3 border-bottom pb-2">
                <!-- Данные пользователя -->
                <div class="col-12 col-md-2"><strong>Имя:</strong> {{$user->name}}</div>
                <div class="col-12 col-md-2"><strong>Логин:</strong> {{$user->login}}</div>
                <div class="col-12 col-md-3"><strong>Email:</strong> {{$user->email}}</div>
                <div class="col-12 col-md-3"><strong>UUID:</strong> {{$user->uuid}}</div>
                <div class="col-12 col-md-2"><strong>Дата:</strong> {{$user->created_at}}</div>

                <!-- Кнопки -->
                <div class="col-12 mt-2 mt-md-0 col-md-12 d-flex justify-content-end gap-2">
                    <form class="d-inline editUserListForm">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <button class="btn btn-warning btn-sm">Изменить</button>
                    </form>
                    <form class="d-inline deleteUserListForm">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <button class="btn btn-danger btn-sm">Удалить</button>
                    </form>
                    <form class="d-inline banUserListForm">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <button class="btn btn-dark btn-sm">Забанить</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

@endsection

@section('custom-scripts')
    <script>
        $(document).ready(function () {
            let url = 'ws://127.0.0.1:8090?channel=user-list&email={{ Auth::user()->email }}&token=34c4adabb11b632c84426f5bb3c6e85f';
            connectWebSocket(handleMessage, url);
        });
    </script>
@endsection
