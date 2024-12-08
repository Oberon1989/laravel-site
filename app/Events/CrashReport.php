<?php

namespace App\Events;

use App\Constant\Tg\TgConstants;
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

    public function __construct(string $message, string $chatId=TgConstants::COMMON_GROUP_ID)
    {
        $this->message=$message;
        $this->chatId=$chatId;
    }
}
