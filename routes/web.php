<?php

use App\Constants\Tg\TgConstants;
use App\Events\CrashReport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SeverController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('users')->name('Users.')->middleware('auth')->group(function(){
    Route::get('view/{user}', [UserController::class, 'getProfileView'])->name('getProfileViewRoute');
    Route::post('edit', [UserController::class, 'editUser'])->name('editUserRoute');
    Route::get('edit/view/{user}', [UserController::class, 'editUserView'])->name('editUserViewRoute');
});

Route::middleware('auth')->group(function(){
    Route::get('/logout', [UserController::class, 'logout'])->name('logoutRoute');
    Route::get('/', function () {
        CrashReport::dispatch("вызвался метод profile",TgConstants::DEV_GROUP_ID);
        return view('index');
    })->name('indexRoute');
    Route::post('/upload-image',[FileController::class,'uploadImage'])->name('uploadImageRoute');
    Route::get('/upload-image',[FileController::class,'uploadImageView'])->name('uploadImageViewRoute');

    Route::get('profile',[UserController::class,'profile'])->name('profileRoute');


    Route::get('/test',function (\App\Services\ImageService $imageService){
        $s = new App\Http\Controllers\SeverController();
        $user = Auth::user();
        dd($s->getProfile($user->uuid,$user->login,$user,$imageService));
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'loginView'])->name('loginViewRoute');
    Route::post('/login', [UserController::class, 'login'])->name('loginRoute');
    Route::get('/register', [UserController::class, 'registerView'])->name('registerViewRoute');
    Route::post('/register', [UserController::class, 'register'])->name('registerRoute');
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/create-user', [UserController::class, 'registerView'])->name('createUserViewRoute');
    Route::post('/create-user', [UserController::class, 'createNewUser'])->name('createUserRoute');
    Route::get('/wait-confirm-user-list', [UserController::class, 'waitConfirmUsersView'])->name('waitConfirmUserListRoute');
    Route::get('/accept-user/{user}', [UserController::class, 'acceptUser'])->name('acceptUserRoute');
    Route::get('/reject-user/{user}', [UserController::class, 'rejectUser'])->name('rejectUserRoute');
    Route::get('/users', [UserController::class, 'getUsersView'])->name('getUsersViewRoute');
    Route::get('/users/edit-user-modal/{user}', [UserController::class, 'getUsersViewModal'])->name('getUsersViewModalRoute');
});



