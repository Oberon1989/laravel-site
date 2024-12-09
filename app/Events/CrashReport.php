<?php

namespace App\Events;

use App\ConstantS\Tg\TgConstants;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CrashReport
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $chatId;

    public function __construct(string $message, string $chatId=null)
    {
        if(!$chatId){
            $this->chatId=TgConstants::COMMON_GROUP_ID();
        }
        else{
            $this->chatId=$chatId;
        }
        $this->message=$message;

    }
}
