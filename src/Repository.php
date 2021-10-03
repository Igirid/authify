<?php

namespace Igirid\Authify;

use Illuminate\Support\Str;
use Illuminate\Config\Repository as IlluminateRepository;

class Repository extends IlluminateRepository
{
    protected $infix;
    /**
     * Call the parents constructor.
     *
     * @param  array  $items
     * @return void
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
        $this->infix = Str::singular(Str::lower(Str::before(request()->path()), '/'));
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        parent::has($this->qualifyKey($key));
    }

    /**
     * Get the specified configuration value.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        parent::get($this->qualifyKey($key), $default);
    }

    /**
     * Get many configuration values.
     *
     * @param  array  $keys
     * @return array
     */
    public function getMany($keys)
    {
        parent::getMany($this->qualifyKey($keys));
    }

    /**
     * Set a given configuration value.
     *
     * @param  array|string  $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value = null)
    {
        parent::set($this->qualifyKey($key), $value);
    }

    /**
     * Prepend a value onto an array configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function prepend($key, $value)
    {
        parent::prepend($this->qualifyKey($key), $value);
    }

    /**
     * Push a value onto an array configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function push($key, $value)
    {
        parent::push($this->qualifyKey($key), $value);
    }

    /**
     * Qualify key from Fortify.
     *
     * @param  string  $key
     * @return string $key
     */
    protected function qualifyKey($key)
    { 
        if (Str::contains($key, 'fortify.')) {
            return Str::replace('fortify', 'fortify.' . $this->infix, $key);
        }
        if (Str::contains($key, 'fortify-options.')) {
            return Str::replace('fortify-options', 'fortify-options.' . $this->infix, $key);
        }
        return $key;
    }
}
