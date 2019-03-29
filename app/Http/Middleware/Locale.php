<?php

namespace App\Http\Middleware;

use Closure;

class Locale
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
        if (\Session::has('language')) {
            \App::setLocale(\Session::get('language'));
            setlocale(LC_ALL, Config::get('app.locale'));
        }

        return $next($request);
    }
}
