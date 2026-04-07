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

        $isAdmin = false;
        if (isset($user->is_admin)) {
            $isAdmin = (bool) $user->is_admin;
        } elseif (isset($user->role)) {
            $isAdmin = ($user->role === 'admin');
        }

        if (! $isAdmin) {
            abort(403);
        }

        return $next($request);
    }
}