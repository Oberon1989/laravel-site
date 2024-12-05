@extends('layouts/main-layout')

@section('title', 'Плащ и скин')

@section('content')
   <form id="uploadImageForm" method="post" action="{{route('uploadImageRoute')}}">
       @csrf
       <input type="file" name="skin">
       <input type="file" name="cloak">
       <button type="submit">Отправить</button>
   </form>
@endsection

