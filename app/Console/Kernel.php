<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendTaskReminders::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tasks:send-reminders')
                 ->dailyAt('09:00'); // Runs every day at 9:00 AM
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}