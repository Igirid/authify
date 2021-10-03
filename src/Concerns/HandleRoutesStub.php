<?php

namespace Igirid\Authify\Concerns;

use Illuminate\Support\Str;
use Laravel\Fortify\Features;

/**
 * 
 */
trait HandleRoutesStub
{
    /**
     * Get the path to the route file to append routes
     *
     * @param  string  $name (name to be used as prefix)
     * @param  array  $omissions (features of authify that will be ommited)
     * @param  string  $route (api || web - this is the file to which the routes will be written in the laravel project )
     * @return void
     */

    public function makeRoutes(string $name, string $route)
    {
        $route = Str::lower($route);
        $enableViews = config('fortify.views', true);

        $header = $this->buildRouteStub('/routes/header.stub');
        $this->appendStubToFile($this->getRoutePath($route), $header);

        $userHeader = $this->buildRouteStub('/routes/user/header.stub', $name);
        $this->appendStubToFile($this->getRoutePath($route), $userHeader);

        // Profile Information...
        if (Features::enabled(Features::updateProfileInformation())) {
            $profileInformation = $this->buildRouteStub('/routes/user/profile-information.stub');
            $this->appendStubToFile($this->getRoutePath($route), $profileInformation);
        }

        // Passwords...
        if (Features::enabled(Features::updatePasswords())) {
            $passwords = $this->buildRouteStub('/routes/user/password.stub');
            $this->appendStubToFile($this->getRoutePath($route), $passwords);
        }

        // Password Confirmation...
        if ($enableViews) {
            $confirmPassword = $this->buildRouteStub('/routes/user/confirm-password.stub');
            $this->appendStubToFile($this->getRoutePath($route), $confirmPassword);
        }

        $confirmedPasswordStatus = $this->buildRouteStub('/routes/user/confirmed-password-status.stub');
        $this->appendStubToFile($this->getRoutePath($route), $confirmedPasswordStatus);

        $confirmPasswordPost = $this->buildRouteStub('/routes/user/confirm-password-post.stub');
        $this->appendStubToFile($this->getRoutePath($route), $confirmPasswordPost);

        
        $twoFactorAuthentication = $this->buildRouteStub('/routes/user/two-factor-authentication.stub');
        $this->appendStubToFile($this->getRoutePath($route), $twoFactorAuthentication);

        $userFooter = $this->buildRouteStub('/routes/user/footer.stub');
        $this->appendStubToFile($this->getRoutePath($route), $userFooter);

        $footer = $this->buildRouteStub('/routes/footer.stub');
        $this->appendStubToFile($this->getRoutePath($route), $footer);
    }

    /**
     * Append a stub content to a route file
     *
     * @param  string  $path
     * @param  string  $stub
     * @return string
     *
     */
    protected function appendStubToFile($path, $stub)
    {
        return $this->files->append($path, $stub);
    }

    /**
     * Get the path to the route file to append routes
     *
     * @param  string  $path
     * @return string
     *
     */

    protected function getRoutePath($route)
    {
        return base_path('routes/' . $route . '.php');
    }

    /**
     * Build a stub with or without a given prefix (to replace dummy terms).
     *
     * @param  string  $term
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildRouteStub($path, $dummy = 'prefix', $term = null)
    {
        $stub = $this->files->get($this->getRouteStub($path));

        if (blank($term)) {
            return $stub;
        }
        return $this->replaceTerm($stub, $dummy, $term);
    }
    /**
     * Replace the prefix (in plural) for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceTerm($stub, $dummy = 'prefix', $term)
    {
        $term = Str::plural(Str::lower($term));
        $dummyCapitalization = Str::ucfirst($dummy);
        return str_replace(["Dummy$dummyCapitalization", "{{ $dummy }}", "{{$dummy}}"], $term, $stub);
    }

    /**
     * Get the stub
     *
     * @param  string  $path
     * @return string
     *
     */
    protected function getRouteStub($path)
    {
        return $this->getRouteStubsPath() . $path;
    }

    /**
     * Get the path to the stub file
     *
     * @param  string  $path
     * @return string
     *
     */
    protected function getRouteStubsPath()
    {
        return __DIR__ . '/stubs';
    }
}
