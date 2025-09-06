<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Services\PermitService;
use App\Jobs\CheckPermitExpirations;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SendNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('db:dump')->dailyAt('20:00')->withoutOverlapping();
        $schedule->command('db:delete')->dailyAt('20:00')->withoutOverlapping();
        $schedule->command('notify:permitExpire')->dailyAt('8:00')->withoutOverlapping();
        // $schedule->job(new CheckPermitExpirations())->dailyAt('10:47');


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
