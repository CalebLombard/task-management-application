<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task: {{ $task->title }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('tasks.update', $task) }}" method="POST" id="update-form">
            @csrf
            @method('PUT')
            
            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title*</label>
                <input type="text" name="title" id="title" required 
                       value="{{ old('title', $task->title) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            </div>
            
            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">{{ old('description', $task->description) }}</textarea>
            </div>
            
            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status*</label>
                <select name="status" id="status" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                    <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            
            <!-- Assignee -->
            <div class="mb-4">
                <label for="assigned_to" class="block text-gray-700 text-sm font-bold mb-2">Assign To</label>
                <select name="assigned_to" id="assigned_to"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                    <option value="">Unassigned</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Deadline -->
            <div class="mb-4">
                <label for="deadline" class="block text-gray-700 text-sm font-bold mb-2">Deadline</label>
                <input type="datetime-local" name="deadline" id="deadline"
                       value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '') }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Task
                </button>
            </div>
        </form>

        @if (session('success'))
            <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded" 
                x-data="{ show: true }" 
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)">
                {{ session('success') }}
            </div>
        @endif

        <script>
            document.getElementById('update-form').addEventListener('submit', function() {
                this.querySelector('button[type="submit"]').disabled = true;
            });
        </script>

    </div>
</x-app-layout>