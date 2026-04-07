<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     * 
     * Daftar endpoint (URI) yang dikecualikan dari verifikasi CSRF.
     * ini berguna untuk API atau webhook yang tidak memerlukan token CSRF.
     * 
     * @var array<int, string>
     */
    protected $except=[
        //
        //contoh: 'api/*', 'webhook/endpoint', 'another/uri/to/exclude'
        //Tambahkan URI di sini jika tidak ingin dikenai pemeriksaan CSRF
    ];
   
}
