<?php

namespace Igirid\Authify;

use Igirid\Authify\Authify;
use Illuminate\Support\Str;
use Igirid\Authify\Commands\AuthifyScaffold;
use Igirid\Authify\Contracts\Authify as AuthifyContract;
use Laravel\Fortify\FortifyServiceProvider;
use Igirid\Authify\Concerns\ConfigurePublishing;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider as TwoFactorAuthenticationProviderContract;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;


class AuthifyServiceProvider extends FortifyServiceProvider
{
    use ConfigurePublishing;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/fortify.php', $this->getConfig());

        $this->registerResponseBindings();

        $this->app->singleton(
            TwoFactorAuthenticationProviderContract::class,
            TwoFactorAuthenticationProvider::class
        );

        $this->app->bind(StatefulGuard::class, function () {
            return Auth::guard(config('fortify.guard', null));
        });

        $this->app->bind(
            AuthifyContract::class,
            Authify::class
        );
        $this->app->bind(
            'fortify',
            AuthifyController::class
        );

        $this->app->extend('config', function ($items, $app) {
            return new Repository($items);
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            $this->commands([
                AuthifyScaffold::class,
            ]);
        }
    }

    /**
     * get conifg.
     *
     * @return string $config
     */

     public function getConfig(){
        if ($this->app->runningInConsole()) {
            return 'fortify.';
        }
         return 'fortify.' . Str::singular(Str::lower(Str::before(request()->path()), '/'));
     }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        /*
        if (Fortify::$registersRoutes) {
            Route::group([
                'namespace' => 'Laravel\Fortify\Http\Controllers',
                'domain' => config('fortify.domain', null),
                'prefix' => config('fortify.prefix'),
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
            });
        }
        */
    } 
}
