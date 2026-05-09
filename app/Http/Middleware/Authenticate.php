<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login.show');
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        // Cek apakah akun dinonaktifkan setelah login
        $user = Auth::user();
        if ($user && isset($user->is_active) && !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login.show')
                ->withErrors(['email' => 'Akun kamu telah dinonaktifkan. Hubungi admin untuk informasi lebih lanjut.']);
        }

        return $next($request);
    }
}
