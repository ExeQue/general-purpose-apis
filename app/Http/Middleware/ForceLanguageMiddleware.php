<?php


namespace App\Http\Middleware;


use Illuminate\Http\Request;

class ForceLanguageMiddleware
{
    public function handle(Request $request, $next)
    {
        if ($lang = $request->query('lang')) {
            \App::setLocale($lang);
        } else {
            \App::setLocale(substr($request->getPreferredLanguage(), 0, 2));
        }

        return $next($request);
    }
}
