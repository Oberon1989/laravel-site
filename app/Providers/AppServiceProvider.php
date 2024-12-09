<?php

namespace App\Providers;

use App\WebSocketServer\WebSocketServer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(WebSocketServer::class, function ($app) {

            return WebSocketServer::getInstance('127.0.0.1', 8080, false); // Пример с параметрами
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role === 'admin';
        });

    }
}
