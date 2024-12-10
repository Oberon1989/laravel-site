<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WebsocketService
{
    public function sendMessage(string $channel, string $message): int
    {
        $serverUrl = 'http://127.0.0.1:8080/send';
        $data = [
            'channel' => $channel,
            'message' => $message,
        ];

        $response = Http::post($serverUrl, $data);


        if ($response->successful()) {

            return 0;
        } else {
            return 1;
        }
    }
}
