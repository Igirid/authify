<?php

namespace Igirid\Authify;

use Illuminate\Support\ServiceProvider;
use Igirid\Authify\Commands\AuthifyScaffold;

class AuthifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Igirid\Authify\Contracts\Authify',
            'Igirid\Authify\Authify'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/authify.php' => config_path('authify.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                AuthifyScaffold::class,
            ]);
        }
    }
}
