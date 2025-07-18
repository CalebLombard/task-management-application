<?php

namespace App\Http\Controllers;

use App\Models\CSKtask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\TaskDeadlineNotification; 

class CSKtaskController extends Controller
{
    public function index()
    {
        $tasks = CSKtask::with('user')
                   ->where('status', '!=', 'completed')
                   ->latest()
                   ->get();
        
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'category' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        $validated['priority'] = strtolower($validated['priority']);
        $validated['status'] = str_replace(' ', '_', strtolower($validated['status']));

        $task = CSKtask::create($validated);
        
        Log::info('Task created', ['task_id' => $task->id, 'user' => auth()->id()]);
        
        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(CSKtask $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(CSKtask $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, CSKtask $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'category' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        $validated['priority'] = strtolower($validated['priority']);
        $validated['status'] = str_replace(' ', '_', strtolower($validated['status']));

        $task->update($validated);
        
        Log::info('Task updated', ['task_id' => $task->id, 'changes' => $validated]);
        
        if ($validated['status'] === 'completed') {
            return redirect()
                ->route('tasks.completed')
                ->with('success', 'Task marked as completed!');
        }
        
        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(CSKtask $task)
    {
        $task->delete();
        
        Log::notice('Task deleted', ['task_id' => $task->id]);
        
        return back()
            ->with('success', 'Task deleted successfully');
    }

    public function completed()
    {
        $completedTasks = CSKtask::where('status', 'completed')
                            ->with('user')
                            ->latest()
                            ->get();
        
        return view('tasks.completed', compact('completedTasks'));
    }

    public function sendReminder(CSKtask $task)
    {
        $this->authorize('update', $task);

        $daysUntilDue = now()->diffInDays($task->deadline, false);

        $task->user->notify(new TaskDeadlineNotification($task, $daysUntilDue));
        
        return back()->with('success', __('Reminder sent successfully!'));
    }
}
