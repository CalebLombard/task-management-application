<x-app-layout>
    <!-- ... existing header code ... -->

    <div class="py-12">
        <!-- ... existing success message ... -->

        @if($completedTasks->isEmpty())
            <p class="text-gray-500">No completed tasks yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- ... existing headers ... -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Original Deadline</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($completedTasks as $task)
                            <tr>
                                <!-- ... existing columns ... -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($task->deadline)
                                        <span class="@if(\Carbon\Carbon::parse($task->deadline)->lt($task->updated_at)) text-red-600 @endif">
                                            {{ \Carbon\Carbon::parse($task->deadline)->format('M j, Y') }}
                                        </span>
                                    @else
                                        None
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($task->deadline)
                                        @if(\Carbon\Carbon::parse($task->deadline)->gte($task->updated_at))
                                            <span class="text-green-600">Completed on time</span>
                                        @else
                                            <span class="text-red-600">Completed late</span>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>