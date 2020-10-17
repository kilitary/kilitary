<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class delunusedips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delunusedips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        \DB::table('logs')
            ->whereIn('ip', ['109.167.216.238', '188.242.121.209'])
            ->delete();

        return 0;
    }
}
