@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $task->title }}</h1>
            <p class="text-gray-700 mb-4">{{ $task->description }}</p>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-medium">{{ ucfirst($task->status) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Priority</p>
                    <p class="font-medium">{{ ucfirst($task->priority) }}</p>
                </div>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('tasks.edit', $task) }}" 
                   class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Edit
                </a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                            onclick="return confirm('Are you sure you want to delete this task?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection