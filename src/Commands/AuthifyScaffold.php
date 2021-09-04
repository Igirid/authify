<?php

namespace Igirid\Authify\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Igirid\Authify\Contracts\Authify;

class AuthifyScaffold extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'authify:scaffold
                            {name=User : Model name}
                            {route=web : Web based or Api route}
                            {--o|omit=* : Features to omit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffolds an authentication system for a model(User is default)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Authify $authify)
    {
        $name = Str::ucfirst($this->argument('name'));
        $omissions = [...$this->option('omit')];

        //create progress bar
        $bar = $this->output->createProgressBar(10);
        $bar->start();

        foreach ($omissions as &$omit) {
            $omit = Str::ucfirst($omit);
        }
        $bar->advance(2);

        $authify->makeRoutes($name, $omissions, Str::ucfirst($this->option('route')));
        $bar->advance();

        $authify->makeModel($name);
        $bar->advance();

        $authify->makeModelMigration($name);
        $bar->advance();

        if (!in_array('Registeration', $omissions)) {
            $authify->makeRegisterationController($name);
        }
        $bar->advance();

        if (!in_array('Login', $omissions)) {
            $authify->makeLoginController($name);
        }
        $bar->advance();

        if (!in_array('Password', $omissions)) {
            $authify->makePasswordController($name);
        }
        $bar->advance();

        if (!in_array('Verification', $omissions)) {
            $authify->makeVerificationController($name);
        }
        $bar->advance();

        if (!in_array('TwoFA', $omissions)) {
            $authify->makeTwoFAController($name);
            $authify->makeTwoFAMigration($name);
        }
        $bar->advance();
        $bar->finish();

        $this->newLine(2);
        $this->line('Done!');
        $this->newLine(4);
        $this->info("Authify scaffold generated succesfully.");
    }
}
