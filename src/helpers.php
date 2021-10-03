<?php
use Illuminate\Support\Str;

if (! function_exists('fortify')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param  string  $controller
     * @param  array  $method
     * @return void
     */
    function fortify($controller,$method)
    {
        $controller = Str::camel(trim($controller));
        app('fortify')->$controller($method);
    }
}