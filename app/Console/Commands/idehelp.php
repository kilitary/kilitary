<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class idehelp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'idehelp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ide generate helpers';

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
    public function handle()
    {
        $this->call('ide-helper:generate');
        $this->call('ide-helper:eloquent');
        $this->call('ide-helper:meta');
        $this->call('ide-helper:models');

        return 0;
    }
}
