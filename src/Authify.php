<?php

namespace Igirid\Authify;

use Igirid\Authify\Concerns\HandleRouteStubs;
use Igirid\Authify\Concerns\HandleModelStub;
use Illuminate\Filesystem\Filesystem;
use Igirid\Authify\Contracts\Authify as AuthifyContract;

class Authify implements AuthifyContract
{
    use HandleRouteStubs, HandleModelStub;
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
