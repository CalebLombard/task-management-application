<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Completed Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg"> <!-- Changed to dark grey -->
                <div class="p-6 bg-gray-900 border-b border-gray-700"> <!-- Changed to dark grey -->
                    @if (session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($completedTasks->isEmpty())
                        <p class="text-gray-300">No completed tasks yet.</p> <!-- Changed to light grey -->
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700"> <!-- Changed divider color -->
                                <thead class="bg-gray-800"> <!-- Darker grey for header -->
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Title</th> <!-- Light grey text -->
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Priority</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Completed By</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date Completed</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-900 divide-y divide-gray-700"> <!-- Dark grey background -->
                                    @foreach($completedTasks as $task)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $task->title }}</td> <!-- White text -->
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $task->description }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $task->priority === 'high' ? 'bg-red-500 text-white' : 
                                                       ($task->priority === 'medium' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $task->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $task->updated_at->format('M j, Y g:i a') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-400 hover:text-red-300"
                                                            onclick="return confirm('Are you sure you want to delete this task?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>