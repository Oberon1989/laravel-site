<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WebsocketService
{
    public function sendMessage(string $channel, string $message)
    {
        $serverUrl = 'http://127.0.0.1:8080/send';  // Обратите внимание на полный URL с http://
        $data = [
            'channel' => $channel,
            'message' => $message,
        ];

        // Отправка POST-запроса
        $response = Http::post($serverUrl, $data);

        // Обработка ответа (например, проверка статуса ответа)
        if ($response->successful()) {
            // Запрос выполнен успешно
            return $response->json();  // или любые другие действия с успешным ответом
        } else {
            // Обработка ошибки
            return response()->json(['error' => 'Ошибка при отправке сообщения'], 500);
        }
    }
}
