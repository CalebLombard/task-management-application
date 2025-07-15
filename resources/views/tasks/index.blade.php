<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Tasks
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Task List</h1>
            <a href="{{ route('tasks.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200">
                Create New Task
            </a>
        </div>

        <div class="space-y-4">
            @foreach($tasks as $task)
                <div class="bg-white p-6 shadow rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $task->title }}</h3>
                            <p class="text-gray-600 mt-1">{{ $task->description }}</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <span class="px-2 py-1 text-xs font-medium rounded 
                                    {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                                <span class="px-2 py-1 text-xs font-medium rounded 
                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($task->priority) }} Priority
                                </span>
                                @if($task->category)
                                <span class="px-2 py-1 text-xs font-medium rounded bg-purple-100 text-purple-800">
                                    {{ $task->category }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('tasks.edit', $task) }}" 
                               class="text-blue-500 hover:text-blue-700">
                                Edit
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-500 hover:text-red-700"
                                        onclick="return confirm('Are you sure you want to delete this task?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">
                                <span class="font-medium">Assigned To:</span> 
                                {{ $task->user->name ?? 'Unassigned' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">
                                <span class="font-medium">Deadline:</span> 
                                {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('M j, Y') : 'None' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>