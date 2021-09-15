<?php

namespace Igirid\Authify\Concerns;

use Illuminate\Support\Str;
/**
 * 
 */
trait HandleModelStub
{
    /**
     * Get the path to the route file to append routes
     *
     * @param  string  $name (name to be used as model)
     * @return void
     */

    public function makeModel(string $name)
    {
        $model_stub = $this->buildModelStub('/model.stub');
        $path = $this->getModelPath($name);
        $this->createModelFromStub($path, $model_stub);
    }

    /**
     * Append a stub content to a route file
     *
     * @param  string  $path
     * @param  string  $stub
     * @return string
     *
     */
    protected function createModelFromStub($path, $stub)
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

    protected function getModelDirectory()
    {
        if ($this->files->exists(app_path('Models'))) {
            return app_path('Models');
        }
        return app_path();
    }

    /**
     * Get the path to the model file to append Logic
     *
     * @param  string  $name
     * @return string  $path
     *
     */
    protected function getModelPath($name){
        return $this->getModelDirectory() . Str::ucfirst($name) . '.php';
    }

    /**
     * Get the proper namespace for the model
     *
     * @param  string  $name
     * @return string  $path
     *
     */
    protected function getModelNamespace(){
        if ($this->files->exists(app_path('/Models'))) {
            return 'App\\Models';
        }
        return 'App\\';
    }

    /**
     * Replace the model name in the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceModelInModel($stub, $model)
    {
        $model = Str::lower($model);
        return str_replace(['DummyModel', '{{ model }}', '{{model}}'], $model, $stub);
    }

    /**
     * Replace the namespace in the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceModelNamespace($stub)
    {
        return str_replace(['DummyNamespace', '{{ namespace }}', '{{namespace}}'], $this->getModelNamespace(), $stub);
    }

    /**
     * Get the stub
     *
     * @param  string  $path
     * @return string
     *
     */
    protected function getModelStub($path)
    {
        return $this->getModelStubsPath() . $path;
    }

    /**
     * Get the path to the stub file
     *
     * @param  string  $path
     * @return string
     *
     */
    protected function getModelStubsPath()
    {
        return __DIR__ .'/stubs';
    }

    /**
     * Build a stub with or without the given model.
     *
     * @param  string  $model
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildModelStub($path, $model = null)
    {
        $stub = $this->files->get($this->getModelStub($path));

        if (blank($model)) {
            return $stub;
        }
        return $this->replaceModelInModel($this->replaceModelNamespace($stub), $model);
    }

}
