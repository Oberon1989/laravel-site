<?php

namespace App\Helpers;

use App\Constants\Tg\TgConstants;
use Illuminate\Support\Facades\Http;

class TgSenderHelper
{
    public static function SendMessage(string $message,string $chatId): void
    {
        $chat_id =$chatId;
        $token = TgConstants::BOT_TOKEN();
        $body = ['chat_id'=>$chat_id,'text'=>$message];
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        Http::withHeaders(['Content-Type'=>'application/json'])->post($url,$body);
    }
}
