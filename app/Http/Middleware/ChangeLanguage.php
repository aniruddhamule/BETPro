<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChangeLanguage
{
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale(session('lang', 'en'));
        return $next($request);
    }
}
