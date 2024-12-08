<?php

namespace App\Listeners;

use App\Events\CrashReport;
use App\Helpers\TgSenderHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TelegramNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function handle(CrashReport $event)
    {
        TgSenderHelper::SendMessage($event->message,$event->chatId);
    }
}
