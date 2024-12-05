<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;

class SeverController extends Controller
{
    public function hasJoined(Request $request){

        $username = $request->get('username');
        $serverId = $request->get('serverId');

        if($username && $serverId && strlen($serverId) >=40)
        {
            $user = User::where('username', $username)->first();
            if($user){
                $profile = $this->getProfile($user->uuid,$user->login);
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

    function getProfile($uuid, $username): array
    {
        $textures = []
        if ($skinUrl = route('image', ['username' => $username, 'type' => 'SKIN'])) {
            $textures['SKIN'] = array('url' => $skinUrl);
        }

        if ($capeUrl = route('image', ['username' => $username, 'type' => 'CAPE'])) {
            $textures['CAPE'] = array('url' => $capeUrl);
        }

        $property = array(
            'timestamp' => time(),
            'profileId' => $uuid,
            'profileName' => $username,
            'textures' => $textures
        );

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
