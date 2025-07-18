<?php

namespace App\Console\Commands;

use App\Models\CSKtask;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Notifications\TaskDeadlineNotification;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send email notifications for upcoming task deadlines';

    public function handle()
    {
        $now = Carbon::now();
        
        // Get tasks with deadlines in the next 3 days or overdue by up to 7 days
        $tasks = CSKtask::with('user')
            ->whereNotNull('deadline')
            ->where('status', '!=', 'completed')
            ->whereBetween('deadline', [
                $now->copy()->subDays(7),
                $now->copy()->addDays(3)
            ])
            ->get();

        foreach ($tasks as $task) {
            $daysRemaining = $now->diffInDays($task->deadline, false);
            
            // Only send notification if due within 3 days or overdue up to 7 days
            if ($daysRemaining <= 3 && $daysRemaining >= -7) {
                $task->user->notify(new TaskDeadlineNotification($task, $daysRemaining));
                $this->info("Sent reminder for task '{$task->title}' to {$task->user->email} (Due in {$daysRemaining} days)");
            }
        }

        $this->info('Task reminder notifications sent successfully.');
    }
}