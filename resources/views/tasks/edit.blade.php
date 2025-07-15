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
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('title')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $task->description) }}</textarea>
            </div>
            
            <!-- Status & Priority -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status*</label>
                    <select name="status" id="status" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">Priority*</label>
                    <select name="priority" id="priority" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Assignee -->
            <div class="mb-4">
                <label for="assigned_to" class="block text-gray-700 text-sm font-bold mb-2">Assign To</label>
                <select name="assigned_to" id="assigned_to"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Unassigned</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
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
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <!-- Category -->
            <div class="mb-4">
                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                <input type="text" name="category" id="category"
                       value="{{ old('category', $task->category) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Task
                </button>
                <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancel
                </a>
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