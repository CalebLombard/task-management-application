<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2f3136] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-200">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            
            <!-- Priority Indicators Example -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-[#2f3136] p-4 rounded-lg">
                    <h3 class="font-medium text-red-400">High Priority</h3>
                    <p class="text-gray-300">Urgent tasks</p>
                </div>
                <div class="bg-[#2f3136] p-4 rounded-lg">
                    <h3 class="font-medium text-amber-400">Medium Priority</h3>
                    <p class="text-gray-300">Important but not urgent</p>
                </div>
                <div class="bg-[#2f3136] p-4 rounded-lg">
                    <h3 class="font-medium text-green-400">Low Priority</h3>
                    <p class="text-gray-300">Can be done later</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>