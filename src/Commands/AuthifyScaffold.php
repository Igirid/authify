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
                            {--r|route=web : Web based or Api route}';

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

        //create progress bar
        $bar = $this->output->createProgressBar(4);
        $bar->start();

        $authify->makeRoutes($name, Str::ucfirst($this->option('route')));
        $bar->advance();

        $authify->makeModel($name);
        $bar->advance();

        $authify->setUpFortifyActions($name);
        $bar->advance();

        $bar->finish();

        $this->newLine(2);
        $this->line('Done!');
        $this->newLine(4);
        $this->info("Authify scaffold generated succesfully.");
    }
}
