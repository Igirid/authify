<?php

namespace Igirid\Authify;

use Igirid\Authify\Concerns\HandleRoutesStub;
use Igirid\Authify\Concerns\HandleModelStub;
use Igirid\Authify\Concerns\HandleCreateNewUser;
use Illuminate\Filesystem\Filesystem;
use Igirid\Authify\Contracts\Authify as AuthifyContract;

class Authify implements AuthifyContract
{
    use HandleRoutesStub, HandleModelStub, HandleCreateNewUser;
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

    public function setUpFortifyActions(string $name){
        $this->makeCreateNewUser($name);
    }
}
