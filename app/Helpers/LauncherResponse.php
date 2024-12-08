<?php

namespace App\Helpers;

use App\Models\User;

class LauncherResponse
{
    public static function getResponseArray(User $user,$serverId): array
    {
        if($user)
        {
            if($user->status == -1){
                return ['error' => 'Вы навсегда забанены на этом сервере',
                    'errorMessage' => 'Вы навсегда забанены на этом сервере!',
                    'cause' => 'Вы навсегда забанены на этом сервере'];
            }
            if($user->status == 0){
                return['error' => 'Администратор еще не одобрил вашу решистрацию',
                    'errorMessage' => 'Администратор еще не одобрил вашу регистрацию!',
                    'cause' => 'Администратор еще не одобрил вашу решистрацию'];
            }
            else
            {
                $user->serverID = $serverId;
                $user->save();
                return ['error' => '',
                    'errorMessage' => '',
                    'cause' => ''];
            }
        }
        else
        {
            return ['error' => 'Игрок не найден! Неверный uuid или access token',
                'errorMessage' => 'Игрок не найден! Неверный uuid или access token',
                'cause' => 'Игрок не найден! Неверный uuid или access token'];
        }

    }
}
