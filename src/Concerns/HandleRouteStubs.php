<?php

namespace Igirid\Authify\Concerns;

use Illuminate\Support\Str;
/**
 * 
 */
trait HandleRouteStubs
{
    /**
     * Get the path to the route file to append routes
     *
     * @param  string  $name (name to be used as prefix)
     * @param  array  $omissions (features of authify that will be ommited)
     * @param  string  $route (api || web - this is the file to which the routes will be written in the laravel project )
     * @return void
     */

    public function makeRoutes(string $name, array $omissions, string $route)
    {
        $route = Str::lower($route);

        $header = $this->buildRouteStub('/routes/header.stub', $name);
        $this->appendStubToFile($this->getRoutePath($route), $header);

        if (!in_array('Registeration', $omissions, true)) {
            $registeration_stub = $this->buildRouteStub('/routes/registeration.stub');
            $this->appendStubToFile($this->getRoutePath($route), $registeration_stub);
        }
        if (!in_array('Login', $omissions, true)) {
            $login_stub = $this->buildRouteStub('/routes/login.stub');
            $this->appendStubToFile($this->getRoutePath($route), $login_stub);
        }
        if (!in_array('Verification', $omissions, true)) {
            $verification_stub = $this->buildRouteStub('/routes/verification.stub');
            $this->appendStubToFile($this->getRoutePath($route), $verification_stub);
        }
        if (!in_array('Password', $omissions, true)) {
            $password_stub = $this->buildRouteStub('/routes/password.stub');
            $this->appendStubToFile($this->getRoutePath($route), $password_stub);
        }
        if (!in_array('TwoFA', $omissions, true)) {
            $twofa_stub = $this->buildRouteStub('/routes/twofa.stub');
            $this->appendStubToFile($this->getRoutePath($route), $twofa_stub);
        }

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
     * Build a stub with or without the given prefix.
     *
     * @param  string  $prefix
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildRouteStub($path, $prefix = null)
    {
        $stub = $this->files->get($this->getRouteStub($path));

        if (blank($prefix)) {
            return $stub;
        }
        return $this->replacePrefix($stub, $prefix);
    }
    /**
     * Replace the prefix for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replacePrefix($stub, $prefix)
    {
        $prefix = Str::lower($prefix);

        return str_replace(['DummyPrefix', '{{ prefix }}', '{{prefix}}'], $prefix, $stub);
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
        return __DIR__ .'/stubs';
    }
}
