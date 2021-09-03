<?php

namespace Igirid\Authify\Contracts;

use Igiri\Authify\Concerns\HandleRouteStubs;
use Igiri\Authify\Contracts\Authify as AuthifyContract;

class Authify implements AuthifyContract
{
    use HandleRouteStubs;

    public function makeRegisterationController(string $name)
    {
    }

    public function makeLoginController(string $name)
    {
    }

    public function makeModel(string $name)
    {
    }

    public function makeModelMigration(string $name)
    {
    }

    public function makePasswordController(string $name)
    {
    }

    public function makeVerificationController(string $name)
    {
    }

    public function makeTwoFAController(string $name)
    {
    }

    public function makeTwoFAMigration(string $name)
    {
    }

}
