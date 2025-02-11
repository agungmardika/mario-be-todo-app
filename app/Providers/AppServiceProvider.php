<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\JWTGuard;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register()
    {
        $this->app->singleton('auth.driver', function ($app) {
            return new JWTGuard($app['tymon.jwt'], $app['auth']->createUserProvider('users'), $app['request']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
