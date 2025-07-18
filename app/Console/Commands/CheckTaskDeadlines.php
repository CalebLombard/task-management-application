<?php

namespace App\Console\Commands;

use App\Models\CSKtask;
use App\Notifications\TaskDeadlineReminder;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckTaskDeadlines extends Command
{
    protected $signature = 'tasks:check-deadlines';
    protected $description = 'Check task deadlines and send notifications';

    public function handle()
    {
        // Get tasks with deadlines in the next 3 days or overdue
        $tasks = CSKtask::whereNotNull('deadline')
            ->where('status', '!=', 'completed')
            ->where(function($query) {
                $query->where('deadline', '<=', Carbon::now()->addDays(3))
                      ->where('deadline', '>=', Carbon::now()->subDays(7));
            })
            ->with('user')
            ->get();

        foreach ($tasks as $task) {
            $daysUntilDue = Carbon::now()->diffInDays($task->deadline, false);
            
            // Only notify if due within 3 days or overdue up to 7 days
            if ($daysUntilDue <= 3 && $daysUntilDue >= -7) {
                $task->user->notify(new TaskDeadlineReminder($task, $daysUntilDue));
                $this->info("Sent reminder for task: {$task->title} (Due in {$daysUntilDue} days)");
            }
        }

        $this->info('Deadline check completed.');
    }
}