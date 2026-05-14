<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS when behind Railway/Vercel proxy
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Use Bootstrap pagination
        \Illuminate\Pagination\Paginator::useBootstrap();

        // Custom Mail Transport: Brevo API
        Mail::extend('brevo', function (array $config = []) {
            $key = $config['key'] ?? env('BREVO_KEY');
            return \Symfony\Component\Mailer\Transport::fromDsn('brevo+api://' . urlencode($key) . '@default');
        });
    }
}
