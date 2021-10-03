<?php

namespace Igirid\Authify\Concerns;

use Illuminate\Support\Str;

/**
 * 
 */
trait HandleCreateNewUser
{
    /**
     * Get the path to the route file to append routes
     *
     * @param  string  $name (name to be used as model)
     * @return void
     */

    public function makeCreateNewUser(string $name)
    {
        $model_stub = $this->buildCreateNewUserStub('/create-new-user.stub', $name);
        $path = $this->getCreateNewUserPath($name);
        $this->makeCreateNewUserFromStub($path, $model_stub);
    }

    /**
     * Append a stub content to a route file
     *
     * @param  string  $path
     * @param  string  $stub
     * @return string
     *
     */
    protected function makeCreateNewUserFromStub($path, $stub)
    {
        return $this->files->put($path, $stub);
    }

    /**
     * Get the path to the route file to append routes
     *
     * @param  string  $path
     * @return string
     *
     */

    protected function getCreateNewUserDirectory($name)
    {
        return app_path('Actions/') . Str::ucfirst($name) . '/Fortify' . '/';
    }

    /**
     * Get the path to the model file to append Logic
     *
     * @param  string  $name
     * @return string  $path
     *
     */
    protected function getCreateNewUserPath($name)
    {
        return $this->getCreateNewUserDirectory($name) . 'CreateNewUser' . '.php';
    }

    /**
     * Get the proper namespace for CreateNewUser
     *
     * @param  string  $name
     * @return string  $path
     *
     */
    protected function getCreateNewUserNamespace($name)
    {
        return 'App\\Actions\\' . $name . '\\Fortify';
    }

    /**
     * Get the proper namespace for the model
     *
     * @param  string  $name
     *
     */
    protected function getModelNamespace()
    {
        if ($this->files->exists(app_path('Models'))) {
            return 'App\\Models';
        }
        return 'App';
    }

    /**
     * Replace the model name in the given stub.
     *
     * @param  string  $stub
     * @param  string  $model
     * @return string
     */
    protected function replaceModelInCreateNewUser($stub, $model)
    {
        return str_replace(['DummyAuthenticable', '{{ Authenticable }}', '{{Authenticable}}'], Str::ucfirst($model), $stub);
    }


    /**
     * Replace the namespace in the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceModelNamespaceInCreateNewUser($stub, $name)
    {
        return str_replace(['ModelNamespace', '{{ model-namespace }}', '{{model-namespace}}'], $this->getModelNamespace($), $stub);
    }

    /**
     * Replace the namespace in the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceCreateNewUserNamespace($stub, $name)
    {
        return str_replace(['DummyNamespace', '{{ namespace }}', '{{namespace}}'], $this->getCreateNewUserNamespace($name), $stub);
    }

    /**
     * Get the stub
     *
     * @param  string  $path
     * @return string
     *
     */
    protected function getCreateNewUserStub($path)
    {
        return $this->getCreateNewUserStubsPath() . $path;
    }

    /**
     * Get the path to the stub file
     *
     * @param  string  $path
     * @return string
     *
     */
    protected function getCreateNewUserStubsPath()
    {
        return __DIR__ . '/stubs';
    }

    /**
     * Build a stub with or without the given model.
     *
     * @param  string  $path
     * @return string  $model
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildCreateNewUserStub($path, $model = null)
    {
        $stub = $this->files->get($this->getCreateNewUserStub($path));

        if (blank($model)) {
            return $stub;
        }
        return $this->replaceModelInCreateNewUser(
            $this->replaceModelNamespaceInCreateNewUser(
                $this->replaceCreateNewUserNamespace($stub, $model),
                $model
            ),
            $model
        );
    }
}
