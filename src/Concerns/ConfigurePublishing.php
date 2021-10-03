<?php
namespace Igirid\Authify\Concerns;

trait ConfigurePublishing {

    /**
     * Configure the publishable resources offered by the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../stubs/fortify.php' => config_path('fortify.php'),
            ], 'fortify-config');

            $this->publishes([
                __DIR__.'/stubs/CreateNewUser.php' => app_path('Actions/Fortify/CreateNewUser.php'),
                __DIR__.'/stubs/FortifyServiceProvider.php' => app_path('Providers/FortifyServiceProvider.php'),
                __DIR__.'/stubs/PasswordValidationRules.php' => app_path('Actions/Fortify/PasswordValidationRules.php'),
                __DIR__.'/stubs/ResetUserPassword.php' => app_path('Actions/Fortify/ResetUserPassword.php'),
                __DIR__.'/stubs/UpdateUserProfileInformation.php' => app_path('Actions/Fortify/UpdateUserProfileInformation.php'),
                __DIR__.'/stubs/UpdateUserPassword.php' => app_path('Actions/Fortify/UpdateUserPassword.php'),
            ], 'fortify-support');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'fortify-migrations');
        }
    }
}