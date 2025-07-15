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
        $tasks = Task::with('user')->latest()->get();
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

        $task = Task::create($validated);
        
        Log::info('Task created', ['task_id' => $task->id, 'user' => auth()->id()]);
        
        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully!');
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

        $task->update($validated);
        
        Log::info('Task updated', ['task_id' => $task->id, 'changes' => $validated]);
        
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
}