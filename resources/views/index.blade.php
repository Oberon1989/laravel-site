@extends('layouts/main-layout')

@section('title', 'Techway')

@section('content')
    <h1>Добро пожаловать, {{ Illuminate\Support\Facades\Auth::user()->name ?? 'Unknown' }}</h1>
@endsection
