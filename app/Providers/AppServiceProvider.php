<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Sanitize APP_URL and other env variables to remove potential double quotes from Railway
        if (env('APP_URL')) {
            config(['app.url' => str_replace('"', '', env('APP_URL'))]);
        }

        if (app()->environment('production') || config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
