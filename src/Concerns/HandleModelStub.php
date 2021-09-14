<?php

namespace Igirid\Authify\Concerns;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

/**
 * 
 */
trait HandleModelStub
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Get the path to the route file to append routes
     *
     * @param  string  $name (name which will be used as model)
     * @param  array  $omissions (features of authify that will be ommited)
     * @param  string  $route (api || web - this is the file to which the routes will be written in the laravel project )
     * @return void
     */

    public function makeModel(string $name)
    {
        $model_stub = $this->buildStub('/model.stub');
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
    protected function getNamespace(){
        if ($this->files->exists(app_path('Models'))) {
            return 'App\\Models\\';
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
    protected function replaceModel($stub, $model)
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
    protected function replaceNamespace(&$stub)
    {
        $namespace = $this->getNamespace();
        return str_replace(['DummyNamespace', '{{ namespace }}', '{{namespace}}'], $namespace, $stub);
    }

    /**
     * Get the stub
     *
     * @param  string  $path
     * @return string
     *
     */
    protected function getStub($path)
    {
        return $this->stubsPath() . $path;
    }

    /**
     * Get the path to the stub file
     *
     * @param  string  $path
     * @return string
     *
     */
    protected function stubsPath()
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
    protected function buildStub($path, $model = null)
    {
        $stub = $this->files->get($this->getStub($path));

        if (blank($model)) {
            return $stub;
        }
        return $this->replaceModel($this->replaceNamespace($stub), $model);
    }

}
