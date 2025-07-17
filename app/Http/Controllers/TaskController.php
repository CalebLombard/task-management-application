<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')
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
            'deadline' => 'nullable|date'
        ]);

        // Ensure consistent case format
        $validated['priority'] = strtolower($validated['priority']);
        $validated['status'] = str_replace(' ', '_', strtolower($validated['status']));

        $task = Task::create($validated);
        
        Log::info('Task created', ['task_id' => $task->id, 'user' => auth()->id()]);
        
        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'category' => 'nullable|string|max:255',
            'deadline' => 'nullable|date'
        ]);

        // Ensure consistent case format
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

    public function destroy(Task $task)
    {
        $task->delete();
        
        Log::notice('Task deleted', ['task_id' => $task->id]);
        
        return back()
            ->with('success', 'Task deleted successfully');
    }

    public function completed()
    {
        $completedTasks = Task::where('status', 'completed')
                            ->with('user')
                            ->latest()
                            ->get();
        
        return view('tasks.completed', compact('completedTasks'));
    }

    public function sendReminder(Task $task)
{
    $this->authorize('update', $task);
    
    $daysUntilDue = now()->diffInDays($task->deadline, false);
    $task->user->notify(new TaskDeadlineNotification($task, $daysUntilDue));
    
    return back()->with('success', __('Reminder sent successfully!'));
}
}