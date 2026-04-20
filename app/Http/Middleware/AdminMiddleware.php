<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.show');
        }

        // Check if user has admin or super_admin role
        $isAdmin = false;
        if (isset($user->role)) {
            $isAdmin = in_array($user->role, ['admin', 'super_admin']);
        }

        if (!$isAdmin) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin admin.');
        }

        return $next($request);
    }
}