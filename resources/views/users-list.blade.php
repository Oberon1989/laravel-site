@extends('layouts/main-layout')

@section('title', 'Список пользователей')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Список пользователей</h1>
        @foreach($users as $user)
            <div class="row align-items-center mb-3 border-bottom pb-2 userRow">
                <div class="col-12 col-md-2 userIdCol"><strong>ID:</strong><p>{{$user->id}}</p></div>
                <div class="col-12 col-md-2 nameCol"><strong>Имя: </strong><p>{{$user->name}}</p></div>
                <div class="col-12 col-md-2 loginCol"><strong>Логин: </strong><p>{{$user->login}}</p></div>
                <div class="col-12 col-md-3 emailCol"><strong>Email: </strong><p>{{$user->email}}</p></div>
                <div class="col-12 col-md-3 uuidCol"><strong>UUID: </strong><p>{{$user->uuid}}</p></div>
                <div class="col-12 col-md-2 dataCol"><strong>Дата: </strong><p>{{$user->created_at}}</p></div>

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

    <script src="{{ asset('js/websock.js') }}"></script>
    <script>

        function updateUserRow(data) {

            data = JSON.parse(data);

            const userRow = $('.userRow').find('.userIdCol').filter(function () {
                const userIdText = $(this).find('p').text();

                return parseInt(userIdText) === parseInt(data.user_id);
            }).first().closest('.userRow');

            console.log(userRow)
           if(userRow.length!==0){
               setText(userRow,'.nameCol',data.user_name)
               setText(userRow,'.loginCol',data.user_login)
               setText(userRow,'.emailCol',data.user_email)
               setText(userRow,'.uuiCol',data.user_uuid)
           }

        }

        $(document).ready(function () {
            let url = 'ws://127.0.0.1:8090?channel=user-list&token=d9e29ed8ff5d37a878f1ecff36aeccad';
            connectWebSocket(updateUserRow, url);
        });

        function setText(elem,className, text){
           $($(elem).find(className).first()).find('p').first().text(text)


        }
    </script>
@endsection
