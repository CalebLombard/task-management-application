<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Edit Task: {{ $task->title }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-4">
        <form action="{{ route('tasks.update', $task) }}" method="POST" id="update-form">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-white">Title*</label>
                    <input type="text" name="title" id="title" required 
                           value="{{ old('title', $task->title) }}"
                           class="mt-1 block w-full rounded-md bg-white border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-white">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full rounded-md bg-white border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500">{{ old('description', $task->description) }}</textarea>
                </div>
                
                <!-- Status & Priority -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-white">Status*</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md bg-white border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="priority" class="block text-sm font-medium text-white">Priority*</label>
                        <select name="priority" id="priority" required
                                class="mt-1 block w-full rounded-md bg-white border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Assignee -->
                <div>
                    <label for="assigned_to" class="block text-sm font-medium text-white">Assign To</label>
                    <select name="assigned_to" id="assigned_to"
                            class="mt-1 block w-full rounded-md bg-white border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Unassigned</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-medium text-white">Deadline</label>
                    <input type="datetime-local" name="deadline" id="deadline"
                           value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '') }}"
                           class="mt-1 block w-full rounded-md bg-white border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-white">Category</label>
                    <input type="text" name="category" id="category"
                           value="{{ old('category', $task->category) }}"
                           class="mt-1 block w-full rounded-md bg-white border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500">
                </div>
                
                <!-- Buttons -->
                <div class="mt-6">
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Task
                    </button>
                    <a href="{{ route('tasks.index') }}" 
                       class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                </div>
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

        <style>
            ::placeholder {
                color: #6B7280 !important;
                opacity: 1 !important;
            }
            select:invalid, select option[value=""] {
                color: #6B7280 !important;
            }
            input[type="datetime-local"]::-webkit-calendar-picker-indicator {
                filter: invert(0);
            }
        </style>
    </div>
</x-app-layout>