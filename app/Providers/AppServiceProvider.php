<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::withoutDoubleEncoding();
        Paginator::useBootstrap();

        if (env('FORCE_HTTPS')) {
            url()->forceScheme('https');
        }
        if (app()->environment('local')) {
            Auth::shouldUse('web');
            // Or create a fake user for API testing
        }
    }
}
