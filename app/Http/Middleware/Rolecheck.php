<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Rolecheck
{
    /**
     * Handle an incoming request.
     *@param \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param mixed ...$roles
     * @return mixed
     */
    public function handle($request , Closure $next, ...$roles)

    {
        if (!Auth::check()) {
            return redirect('login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'akses ditolak, Pengguna tidak memiliki izin'); // Forbidden
        }

        return $next($request);
    }
}
