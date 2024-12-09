<?php

namespace App\Constants\Tg;

class TgConstants
{
    public static function BOT_TOKEN(): string
    {
        return env('BOT_TOKEN', 'default_bot_token');
    }

    public static function COMMON_GROUP_ID(): string
    {
        return env('COMMON_GROUP_ID', 'default_common_group_id');
    }

    public static function DEV_GROUP_ID(): string
    {
        return env('DEV_GROUP_ID', 'default_dev_group_id');
    }
}
