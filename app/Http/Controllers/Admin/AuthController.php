<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $authCredentials = $credentials;

        if (Schema::hasColumn('users', 'is_active')) {
            $authCredentials['is_active'] = true;
        }

        if (!Auth::attempt($authCredentials, $request->boolean('remember'))) {
            if (Schema::hasColumn('users', 'is_active')) {
                $user = User::where('email', $credentials['email'])->first();

                if ($user && ! $user->is_active) {
                    return back()
                        ->withErrors(['email' => 'Cet utilisateur est désactivé.'])
                        ->onlyInput('email');
                }
            }

            return back()
                ->withErrors(['email' => 'Identifiants invalides.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('admin_authenticated', true);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->forget('admin_authenticated');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
