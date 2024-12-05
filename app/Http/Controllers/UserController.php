<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function registerView() : View{
        return view('register');
    }

    public function register(Request $request){

    }

    public function loginView(Request $request): View | RedirectResponse
    {
        return view('login');
    }

    public function login(Request $request){
        $email = $request->get("email");
        $password = $request->get("password");

        $user = User::where("email", $email)->first();
        if(!$user){
            return response()->json([],401);
        }
        else
        {
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                return response()->json(['user' => Auth::user()]);
            } else {
                return response()->json([],401);
            }
        }
    }
}
