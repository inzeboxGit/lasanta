<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (
            !(bool) $request->session()->get('admin_authenticated', false)
            || ! $user
            || (Schema::hasColumn('users', 'is_active') && ! $user->is_active)
        ) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
