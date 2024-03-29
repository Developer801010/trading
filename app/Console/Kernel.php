<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\BookNotify;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        BookNotify::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('queue:work --stop-when-empty')
             ->everyMinute()
             ->withoutOverlapping();

		$schedule->command('app:fetch-stock-price')
			->everyThirtyMinutes()
			->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
