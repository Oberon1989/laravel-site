<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeverController;

Route::prefix('minecraft')->group(function () {
    Route::get('join', [SeverController::class, 'join'])->name('joinRoute');
    Route::get('has-joined', [SeverController::class, 'hasJoined'])->name('hasJoinedRoute');
    Route::get('profile', [SeverController::class, 'profile'])->name('minecraftProfileRoute');
});

