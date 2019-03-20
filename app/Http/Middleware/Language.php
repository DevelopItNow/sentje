<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('applocale') && array_key_exists(\Session::get('applocale'), \Config::get('languages'))) {
            App::setLocale(Session::get('applocale'));
        }
        return $next($request);
    }
}
