<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use App\Services\Gate\GateCache;
use Debugbar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        Debugbar::enable();

        // Rebind GateContract to GateCache
        $this->app->singleton(GateContract::class, function ($app) {
            return new GateCache($app, function () use ($app) {
                return call_user_func($app['auth']->userResolver());
            });
        });

        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bootstrap any application services.
    }
}
