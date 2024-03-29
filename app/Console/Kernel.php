<?php
declare(strict_types=1);

namespace App\Console;

use App\Jobs\ClearOldShit;
use App\Jobs\FetchProxy;
use App\Jobs\IpInfoResolver;
use App\Jobs\RedisSaver;
use App\Jobs\TelescopPrune;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new ClearOldShit)
            ->everyFiveMinutes()
            ->sendOutputTo(base_path() . '/shedule.log');

        $schedule->job(new TelescopPrune)
            ->everyTwoHours()
            ->sendOutputTo(base_path() . '/shedule.log');

        $schedule->call(function () {
            \DB::table('logs')
                ->whereIn('ip', config('site.adminips'))
                ->delete();
        })->everyMinute();

        $schedule->job(new RedisSaver)
            ->everyFiveMinutes()
            ->withoutOverlapping();

        $schedule->job(new IpInfoResolver)
            ->everyTwoMinutes()
            ->withoutOverlapping();

//        $schedule->job(new FetchProxy)
//            ->everyFourHours()
//            ->withoutOverlapping();

//        $schedule->job(new ProxySoftwareNamer)
//            ->everyTenMinutes()
//            ->withoutOverlapping();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function scheduleTimezone()
    {
        return 'Europe/Moscow';
    }
}
