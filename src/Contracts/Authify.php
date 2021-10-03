<?php
namespace Igirid\Authify\Contracts;

interface Authify{
    public function makeRoutes(String $name, String $route);

    public function makeModel(String $name);

    public function setUpFortifyActions(String $name);

    /*

    public function makeLoginController(String $name);

    public function makeRegisterationController(String $name);

    public function makeVerificationController(String $name);

    public function makePasswordController(String $name);

    public function makeTwoFAController(String $name);

    public function makeTwoFAMigration(String $name);
    */
}