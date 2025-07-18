<?php

namespace App\Notifications;

use App\Models\CSKtask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;
    public $daysRemaining;

    public function __construct(CSKtask $task, int $daysRemaining)
    {
        $this->task = $task;
        $this->daysRemaining = $daysRemaining;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->getSubject();

        return (new MailMessage)
            ->subject($subject)
            ->line($subject)
            ->line('Task Details:')
            ->line('Title: ' . $this->task->title)
            ->line('Description: ' . $this->task->description)
            ->line('Priority: ' . ucfirst($this->task->priority))
            ->line('Deadline: ' . $this->task->deadline->format('F j, Y, g:i a'))
            ->action('View Task', route('tasks.show', $this->task->id))
            ->line('Thank you for using our task management system!');
    }

    protected function getSubject()
    {
        if ($this->daysRemaining === 0) {
            return "❗ Task '{$this->task->title}' is due today!";
        } elseif ($this->daysRemaining < 0) {
            return "⚠️ Task '{$this->task->title}' is overdue by " . abs($this->daysRemaining) . " days!";
        } else {
            return "🔔 Reminder: Task '{$this->task->title}' due in {$this->daysRemaining} days";
        }
    }
}