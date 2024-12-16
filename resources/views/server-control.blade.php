@extends('layouts/main-layout')

@section('title', 'Сервер')

@section('content')

<div class="container mt-4">
    <!-- Заголовок -->
    <h3 class="text-center mb-3">Консоль сервера</h3>

    <!-- Поле вывода информации от сервера -->
    <div class="p-3 mb-3 border rounded" id="serverConsole" style="height: 300px; background-color: black; color: white; overflow-y: scroll;">
        <p>Здесь будет вывод информации от сервера...</p>
    </div>

    <!-- Поле ввода команды -->
    <div class="mb-3">
        <label for="commandInput" class="form-label">Введите команду:</label>
        <input type="text" id="commandInput" class="form-control" placeholder="Введите команду для сервера">
    </div>

    <!-- Кнопки управления -->
    <div class="d-flex gap-2">
        <button class="btn btn-primary" id="sendCommand">Отправить</button>
        <button class="btn btn-danger" id="stopServer">Остановить сервер</button>
        <button class="btn btn-success" id="restartServer">Перезапустить сервер</button>
    </div>
</div>
@endsection
