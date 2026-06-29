<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Closure;

final class SentinelAuth
{
    public function handle(Request $request, Closure $next): mixed
    {
        if(! Sentinel::check()) {
            return redirect('/login');
        }

        // DESTROI A SESSAO E REDIRECIONA O USUARIO PARA A PAGINA DE LOGIN
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        // return redirect('/login');

        return $next($request);
    }
}
