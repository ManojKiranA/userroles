<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use App\Services\Gate\GateCache;
use Debugbar;
use Illuminate\Database\Eloquent\Builder;

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
        Builder::macro('search', function ($tableFields, $searchValues, $splitOn = null, $addOwnWildCard = true) {

            $tableFields = (array) $tableFields;
            $searchValues = (array) $searchValues;

            if ($splitOn !== null && array_filter($splitOn) !== []) {
                foreach ($searchValues as  $searchTerm) {
                    $splitOnSpaceArray[] = explode(chr(1), str_replace($splitOn, chr(1), $searchTerm));
                }
                $searchValues = \Illuminate\Support\Arr::collapse($splitOnSpaceArray);
            }
            if ($addOwnWildCard) {
                foreach ($searchValues as  $searchTerm) {
                    $addWildOnEach[] = "%{$searchTerm}%";
                }
                $searchValues = $addWildOnEach;
            }
            $this->where(function ($query) use ($tableFields, $searchValues) {
                foreach ($tableFields as $attribute) {
                    $query->orWhere(function ($query) use ($attribute, $searchValues) {
                        foreach ($searchValues as $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', $searchTerm);
                        }
                    });
                }
            });

            return $this;
        });
    }
}
