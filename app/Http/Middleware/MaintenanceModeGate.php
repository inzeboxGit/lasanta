<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MaintenanceModeGate
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin') || $request->is('admin/*')) {
            return $next($request);
        }

        if (
            Auth::check()
            && (bool) $request->session()->get('admin_authenticated', false)
            && (!Schema::hasColumn('users', 'is_active') || Auth::user()?->is_active)
        ) {
            return $next($request);
        }

        if (
            Auth::check()
            && (bool) $request->session()->get('admin_authenticated', false)
            && Schema::hasColumn('users', 'is_active')
            && ! Auth::user()?->is_active
        ) {
            Auth::logout();
            $request->session()->forget('admin_authenticated');
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        try {
            if (!Schema::hasTable('site_settings')) {
                return $next($request);
            }

            $enabled = SiteSetting::where('setting_key', 'general')->value('maintenance_enabled');

            if (!$enabled) {
                return $next($request);
            }
        } catch (Throwable $e) {
            return $next($request);
        }

        return response()->view(themed_view_name('maintenance'), status: 503);
    }
}
