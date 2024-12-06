<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle($request, Closure $next, string $role)
    {

        if (!Auth::check()) {
            return redirect()->route('loginViewRoute')->with('error', 'Вы должны войти в систему.');
        }

        if (Auth::user()->role !== $role) {
            return redirect()->route('indexRoute')->with('error', 'У вас нет доступа к этой странице.');
        }

        return $next($request);
    }
}
