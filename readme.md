# Authify 
Authify is designed for some Laravel lovers in the Milky-Way who would - for some valid reason - rather have seperate models for different user types in their application. We'll generate those Boilerplate for you, exposing them in the `App\Http\Controllers` namespace, because we understand you may still need to tweak it to coresspond fully with your project demands.

> Note That We Do Not Re-invent The Wheel (except in terms of 2FA), We harmonously integrate pre-existing Laravel features into a single package.

## Requirements

1. "laravel/framework" : "^8.54"


# Configuration 

## Publish Authify's Resources using the `vendor:publish` command

`php artisan vendor:publish --provider="Igirid\Authify\AuthifyServiceProvider"`


##  Ensure `$namespace` in your RouteServiceProvider.php is `'App\Http\Controllers'`

```
<?php

namespace App\Providers;
...

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
...

class RouteServiceProvider extends ServiceProvider
{
    ...

    protected $namespace = 'App\\Http\\Controllers';

    ...
```
## Authify Scaffold

This scaffolds an authentication, registration, verification, password reset, password update and a 2fa system. 

###  Command syntax `php artisan authify:scaffold {model} --omit=[,login,registeration,password,verification,2fa] ` 


###  Examples

`php:artisan authify:scaffold User` generates all of Authify's services for the User Model.

`php:artisan authify:scaffold  Admin --omit=registration` generates all of Authify's services except registeration for the Admin model.

`php:artisan authify:scaffold Client --omit=registration -o=verification` generates all of Authify's services omitting registeration and verification for the admin Model.


