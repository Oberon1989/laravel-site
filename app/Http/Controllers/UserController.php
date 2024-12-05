<?php

namespace App\Http\Controllers;

use http\Client\Request;

class UserController extends Controller
{
    public function registerView(){
        return view('register');
    }

    public function register(Request $request){

    }
}
