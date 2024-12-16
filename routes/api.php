<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeverController;

Route::prefix('minecraft')->group(function () {
    Route::post('join', [SeverController::class, 'join'])->name('apiJoinRoute');
    Route::post('login', [SeverController::class, 'login'])->name('apiLoginRoute');
    Route::get('has-joined', [SeverController::class, 'hasJoined'])->name('hasJoinedRoute');
    Route::post('profile', [SeverController::class, 'profile'])->name('minecraftProfileRoute');

});


