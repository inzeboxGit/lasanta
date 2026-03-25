<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locales = array_keys(config('content_translations.locales', ['fr' => 'Français']));
        $default = config('app.locale', 'fr');

        if (Schema::hasTable('site_settings') && Schema::hasColumn('site_settings', 'default_locale')) {
            $storedDefault = SiteSetting::where('setting_key', 'general')->value('default_locale');
            if (is_string($storedDefault) && in_array($storedDefault, $locales, true)) {
                $default = $storedDefault;
            }
        }

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
