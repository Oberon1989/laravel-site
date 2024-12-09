<?php

namespace App\Services;

use WebSocket\Client;

class BackendWebSockClient
{
    public function connectToChannel($channel, $message): void
    {

        $message = urlencode($message);
        $wsUrl = "ws://127.0.0.1:8080?channel={$channel}&message={$message}";
        try {

            $client = new Client($wsUrl);
            $client->connect();
            $client->close();
            echo "Соединение закрыто\n";

        } catch (\Exception $e) {
            echo "Ошибка подключения: {$e->getMessage()}\n";
        }

    }
}
