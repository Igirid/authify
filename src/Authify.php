<?php

namespace Igirid\Authify;

use Igirid\Authify\Concerns\HandleRouteStubs;
use Igirid\Authify\Concerns\HandleModelStub;
use Igirid\Authify\Contracts\Authify as AuthifyContract;

class Authify implements AuthifyContract
{
    use HandleRouteStubs, HandleModelStub;

    public function makeRegisterationController(string $name)
    {
    }

    public function makeLoginController(string $name)
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
