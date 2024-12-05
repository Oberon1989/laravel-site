@extends('layouts/main-layout')

@section('title', 'Login')

@section('content')
   <form id="loginForm" method="post" action="{{route('loginRoute')}}">
       @csrf
       <input type = "email" name = "email">
       <input type = "password" name = "password">
       <button type="submit">Войти</button>
   </form>
@endsection
