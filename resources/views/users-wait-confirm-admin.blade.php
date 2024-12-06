@extends('layouts/main-layout')

@section('title', 'Ожидающие пользователи')

@section('content')
    <div class="row">
        @foreach($users as $user)
            <div class="col-md-12 mb-4">
                <div class="card userItem">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2"><strong>Имя:</strong></div>
                            <div class="col-md-10">{{ $user->name }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><strong>Логин:</strong></div>
                            <div class="col-md-10">{{ $user->login }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><strong>Email:</strong></div>
                            <div class="col-md-10">{{ $user->email }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><strong>UUID:</strong></div>
                            <div class="col-md-10">{{ $user->uuid }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><strong>Роль:</strong></div>
                            <div class="col-md-10">{{ $user->role }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><strong>Статус:</strong></div>
                            <div class="col-md-10">{{ $user->status }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><strong>Дата регистрации:</strong></div>
                            <div class="col-md-10">{{ $user->created_at }}</div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <form class="processUser">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-success accept">Подтвердить</button>
                            <button type="submit" class="btn btn-danger reject">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
