<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
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

        $name = $request->get('name');
        $login = $request->get('login');
        $email = $request->get('email');
        $password = $request->get('password');
        if(User::where('email', $email)->exists()){
            return response()->json(['message' => 'Пользователь с таким адресом электронной почты уже существует!'],409);
        }
        if(User::where('login', $login)->exists()){
            return response()->json(['message' => 'Пользователь с таким логином уже существует!'],409);
        }
        User::create(['name'=>$name,'login'=>$login,'email'=>$email,'password'=>bcrypt($password)]);
        return response()->json(['message' => 'Заявка на регистрацию отправлена. ожидайте подтверждения админа!']);
    }

    public function createNewUser(Request $request)
    {
        $name = $request->get('name');
        $login = $request->get('login');
        $email = $request->get('email');
        $role = $request->get('role');
        $status=$request->get('status');
        $password = $request->get('password');

        if(User::where('email', $email)->exists()){
            return response()->json(['message' => 'Пользователь с таким адресом электронной почты уже существует!'],409);
        }
        if(User::where('login', $login)->exists()){
            return response()->json(['message' => 'Пользователь с таким логином уже существует!'],409);
        }

        User::create(['name'=>$name,'login'=>$login,'email'=>$email,'password'=>bcrypt($password),'role'=>$role,'status'=>$status]);
        return response()->json(['message' => 'Пользователь успешно создан!']);

    }

    public function loginView(Request $request): View
    {
        return view('login');
    }

    public function login(Request $request): JsonResponse
    {
        $email = $request->get("email");
        $password = $request->get("password");
        $user = User::where("email", $email)->first();

        if(!$user){
            return response()->json(['message'=>'Пользователь с таким email не найден'],401);
        }
        else
        {
            if (Hash::check($password, $user->password)) {
                if($user->status==1){
                    Auth::login($user);
                    return response()->json(['message' => "Вы успешно вошли, $user->name"]);
                }
                else
                {
                    return response()->json(['message' => 'Админстратор еще не обработал вашу заявку на регистрацию, ожидайте!'],401);
                }

            } else {
                return response()->json(['message'=>'Пароль неверный'],401);
            }
        }
    }

    public function waitConfirmUsersView() :View
    {
        $users = User::where('status','=',0)->get();
        return view('users-wait-confirm-admin',['users'=>$users]);
    }
    public function acceptUser(User $user)
    {

        $user->status=1;
        $user->save();
        return response()->json(['message'=>'Заявка для '.$user->email.' принята']);
    }

    public function rejectUser(User $user)
    {
        $email = $user->email;
        $user->delete();
        return response()->json(['message'=>'Заявка для '.$email.' отклонена']);
    }
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('loginRoute');
    }

    public function getProfileView(User $user) : RedirectResponse | View
    {
        if($this->isAdmin() || Auth::user()->id===$user->id)
        {
            return view('user-profile',['user'=>$user]);
        }
        else return redirect()->route('indexRoute')->with('error', 'Вы не можете смотреть чужой профиль!');

    }

    public function editUser(Request $request)
    {
        $user = User::find($request->get('user_id'));
        if(!$user){
            return response()->json(['message'=>'пользователь не найден в базе данных'],404);
        }
        $user->name = $request->get('name');
        $user->login = $request->get('login');
        $user->password = bcrypt($request->get('password'));
        $role = $request->get('role');
        $status=$request->get('status');
        if($role){
            $user->role = $role;
        }
        if($status){
            $user->status = $status;
        }
        $user->save();

        return response()->json(['message'=>'Данные обновлены.']);
    }
    public function editUserView(User $user) : View
    {
        return view('edit-user',['user'=>$user]);
    }

    public function getUsersView()
    {
        $users = User::all();
        return view('users-list',['users'=>$users]);
    }

    public function getUsersViewModal(User $user)
    {
        return view('components.edit-user-component',['user'=>$user]);
    }
}
