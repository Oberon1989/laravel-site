<?php

namespace App\Http\Controllers;

use App\Constants\Tg\TgConstants;
use App\Events\CrashReport;
use App\Models\User;
use App\Services\ImageService;
use App\Services\LauncherServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeverController extends Controller
{
    public function hasJoined(Request $request,ImageService $imageService) : JsonResponse
    {
        $username = $request->get('username');
        $serverId = $request->get('serverId');
        if($username && $serverId && strlen($serverId) >=40)
        {
            $user = User::where('login', $username)
            ->where('serverID',$serverId)->where('status','>','0')->first();
            if($user){
                $profile = $this->getProfile($user->uuid,$user->login,$user,$imageService);

                return response()->json($profile);
            }
            else
            {
                return response()->json([],404);
            }
        }
        else
        {
            return response()->json([],404);
        }

    }

    public function join(Request $request,LauncherServices $launcherServices) : JsonResponse
    {
        return $launcherServices->launcherSendJoin($request);
    }

    public function login(Request $request,LauncherServices $launcherServices) : JsonResponse
    {
        return $launcherServices->getResponseObj($request);
    }

    public function profile(Request $request) : JsonResponse
    {
        CrashReport::dispatch("вызвался метод profile",TgConstants::DEV_GROUP_ID());
        return response()->json([]);
    }

    public function getServerControlView() : View
    {
        return view('server-control');
    }



    function getProfile($uuid, $username, User $user, ImageService $imageService): array
    {
        $textures = [];
        $images = $imageService->getUserSkinCloak($user);
        if ($images['skin']) {
            $textures['SKIN'] = ['url' => $images['skin']];
        }
        if ($images['cloak']) {
            $textures['CAPE'] = ['url' => $images['cloak']];
        }


        $property = [
            'timestamp' => time(),
            'profileId' => $uuid,
            'profileName' => $username,
            'textures' => $textures
        ];

        return [
            'id' => $uuid,
            'name' => $username,
            'properties' => [
                0 => [
                    'name' => 'textures',
                    'value' => base64_encode(json_encode($property, JSON_UNESCAPED_SLASHES)),
                    'signature' => ''
                ]
            ]
        ];
    }


}
