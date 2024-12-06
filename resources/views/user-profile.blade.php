
@extends('layouts/main-layout')

@section('title', 'Профиль')

@section('content')
    <a href="{{route('Users.editUserViewRoute',[Auth::user()])}}">Изменить данные</a>
@endsection

