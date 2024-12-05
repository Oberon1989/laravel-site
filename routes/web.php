<?php

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



Route::middleware('auth')->group(function(){
    Route::get('/', function () {
        return view('index');
    })->name('indexRoute');
    Route::post('/upload-image',[FileController::class,'uploadImage'])->name('uploadImageRoute');
    Route::get('/upload-image',[FileController::class,'uploadImageView'])->name('uploadImageViewRoute');
    Route::get('/test',function (\App\Services\ImageService $imageService){
        $s = new App\Http\Controllers\SeverController();
        $user = Auth::user();
        dd($s->getProfile($user->uuid,$user->login,$user,$imageService));
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'loginView'])->name('loginViewRoute');
    Route::post('/login', [UserController::class, 'login'])->name('loginRoute');
});


