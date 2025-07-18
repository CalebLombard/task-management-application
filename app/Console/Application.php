<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Application as ConsoleApplication;
use App\Models\CSKtask;
use App\Notifications\TaskDeadlineReminder;

class Application extends ConsoleApplication
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $tomorrow = now()->addDay()->startOfDay();
            $tasks = CSKtask::whereDate('deadline', $tomorrow)
                      ->with('user')
                      ->get();

            foreach ($tasks as $task) {
                if ($task->user) {
                    $task->user->notify(new TaskDeadlineReminder($task));
                }
            }
        })->dailyAt('09:00'); 
    }
}