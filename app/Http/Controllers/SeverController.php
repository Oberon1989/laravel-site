<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeverController extends Controller
{
    public function hasJoined(Request $request,ImageService $imageService) : JsonResponse
    {

        $username = $request->get('username');
        $serverId = $request->get('serverId');

        if($username && $serverId && strlen($serverId) >=40)
        {
            $user = User::where('username', $username)->first();
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

    public function join(Request $request) : JsonResponse
    {
        $data = $request->json()->all();
        $email = $data['email'];
        $password = $data['password'];
        $user = User::where('email', '=',$email)
            ->where('password', '=',md5($password))
            ->where('status', '=', 1)
            ->first();

        if($user){
            $accessToken = $this->generateAccessToken();
            $user->access_token = $accessToken;
            $user->save();
            return response()->json(['uuid'=>$user->uuid,'accessToken'=>$user->access_token]);
        }
        else return response()->json(['error'=>'Unauthorized'], 401);
    }

    public function profile(Request $request) : JsonResponse
    {
        return response()->json([]);
    }

    private function generateAccessToken(): string
    {
        srand(time());
        $randNum = rand(1000000000, 2147483647) . rand(1000000000, 2147483647) . rand(0, 9);
        return md5($randNum);
    }

    function getProfile($uuid, $username,User $user,ImageService $imageService): array
    {
       $images = $imageService->getUserSkinCloak($user);
       if($images['skin']){
           $textures['SKIN']=['url' => $images['skin']];
       }
        if($images['cloak']){
            $textures['CAPE']=['url' => $images['cloak']];
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
