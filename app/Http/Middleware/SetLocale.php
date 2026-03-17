<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locales = array_keys(config('content_translations.locales', ['fr' => 'Français']));
        $default = config('app.locale', 'fr');

        $lang = $request->query('lang');
        if ($lang && in_array($lang, $locales, true)) {
            session(['site_locale' => $lang]);
        }

        $locale = session('site_locale', $default);
        if (!in_array($locale, $locales, true)) {
            $locale = $default;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
