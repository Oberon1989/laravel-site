<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use http\Client\Request;

class LauncherController extends Controller
{
    public function login(Request $request){
        $data = $request->json()->all();
        $email = $data['email'];
        $password = $data['password'];
        $user = \App\Models\User::where('email', '=',$email)
            ->where('password', '=',md5($password))
            ->where('status', '=', 1)
            ->first();

        if($user){
            $accessToken = $this->generateAccessToken();
            $user->access_token = $accessToken;
            $user->save();
            return response()->json(['uuid'=>$user->uuid,'accessToken'=>$this->generateAccessToken()]);
        }
        else return response()->json(['error'=>'Unauthorized'], 401);
    }

    private function generateAccessToken(): string
    {
        srand(time());
        $randNum = rand(1000000000, 2147483647) . rand(1000000000, 2147483647) . rand(0, 9);
        return md5($randNum);
    }
}
