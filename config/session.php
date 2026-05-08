<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'database'),

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    'encrypt' => false,

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION'),

    'table' => env('SESSION_TABLE', 'sessions'),

    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel')) . '-session'
    ),

    'path' => '/',

    // Kosongkan domain agar cookie berlaku untuk semua subdomain
    'domain' => null,

    // Secure: true hanya di production (HTTPS), false di local
    'secure' => env('APP_ENV') === 'production',

    'http_only' => true,

    // 'lax' agar Google OAuth callback bisa mengirim cookie
    'same_site' => 'lax',

    'partitioned' => false,

];
