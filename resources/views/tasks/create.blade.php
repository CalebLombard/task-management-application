<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Create New Task
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-4">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-white">Title*</label>
                    <input type="text" name="title" id="title" required 
                           value="{{ old('title') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-black"
                           placeholder="Enter task title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-white">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-black"
                              placeholder="Enter task description">{{ old('description') }}</textarea>
                </div>

                <!-- Status & Priority -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-white">Status*</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black">
                            <option value="" disabled selected>Select status</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="priority" class="block text-sm font-medium text-white">Priority*</label>
                        <select name="priority" id="priority" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black">
                            <option value="" disabled selected>Select priority</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority') == 'medium' || !old('priority') ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Assigned User -->
                <div>
                    <label for="assigned_to" class="block text-sm font-medium text-white">Assign To</label>
                    <select name="assigned_to" id="assigned_to"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black">
                        <option value="" selected>Select user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-medium text-white">Deadline</label>
                    <input type="datetime-local" name="deadline" id="deadline"
                           value="{{ old('deadline') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-white">Category</label>
                    <input type="text" name="category" id="category"
                           value="{{ old('category') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-black"
                           placeholder="Enter category">
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Task
                    </button>
                    <a href="{{ route('tasks.index') }}" 
                       class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <style>
        ::placeholder {
            color: black !important;
            opacity: 1 !important;
        }
        select, select option {
            color: black !important;
        }
        select:invalid, select option[value=""] {
            color: gray !important;
        }
    </style>
</x-app-layout>